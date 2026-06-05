<?php

namespace App\Utils;

use Codedge\Fpdf\Fpdf\Fpdf;

class CustomFpdf extends Fpdf
{
    protected $widths = [];
    protected $aligns = [];

    // ── Métodos para tablas con alto de fila variable ──────────────────────

    public function SetWidths(array $w)
    {
        $this->widths = $w;
    }

    public function SetAligns(array $a)
    {
        $this->aligns = $a;
    }

    public function Row(array $data, $lineHeight = 5)
    {
        $nb = 0;
        for ($i = 0; $i < count($data); $i++) {
            $nb = max($nb, $this->NbLines($this->widths[$i], (string) $data[$i]));
        }
        $h = $lineHeight * $nb;
        $this->CheckPageBreak($h);
        for ($i = 0; $i < count($data); $i++) {
            $w  = $this->widths[$i];
            $a  = isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
            $x  = $this->GetX();
            $y  = $this->GetY();
            $this->Rect($x, $y, $w, $h);
            $this->MultiCell($w, $lineHeight, (string) $data[$i], 0, $a);
            $this->SetXY($x + $w, $y);
        }
        $this->Ln($h);
    }

    public function CheckPageBreak($h)
    {
        if ($this->GetY() + $h > $this->PageBreakTrigger) {
            $this->AddPage($this->CurOrientation);
        }
    }

    public function NbLines($w, $txt)
    {
        $cw = &$this->CurrentFont['cw'];
        if ($w == 0) {
            $w = $this->w - $this->rMargin - $this->x;
        }
        $wmax = ($w - 2 * $this->cMargin) * 1000 / $this->FontSize;
        $s  = str_replace("\r", '', $txt);
        $nb = strlen($s);
        if ($nb > 0 && $s[$nb - 1] == "\n") {
            $nb--;
        }
        $sep = -1;
        $i   = 0;
        $j   = 0;
        $l   = 0;
        $nl  = 1;
        while ($i < $nb) {
            $c = $s[$i];
            if ($c == "\n") {
                $i++;
                $sep = -1;
                $j   = $i;
                $l   = 0;
                $nl++;
                continue;
            }
            if ($c == ' ') {
                $sep = $i;
            }
            $l += isset($cw[$c]) ? $cw[$c] : 600;
            if ($l > $wmax) {
                if ($sep == -1) {
                    if ($i == $j) {
                        $i++;
                    }
                } else {
                    $i = $sep + 1;
                }
                $sep = -1;
                $j   = $i;
                $l   = 0;
                $nl++;
            } else {
                $i++;
            }
        }
        return $nl;
    }

    // ── Cell con soporte multi-línea y parámetro ln igual a Cell() ─────────

    public function MultiAlignCell($w, $h, $txt, $border = 0, $ln = 0, $align = 'J', $fill = false)
    {
        $x = $this->GetX();
        $y = $this->GetY();

        $this->MultiCell($w, $h, $txt, $border, $align, $fill);

        if ($ln == 0) {
            $this->SetXY($x + $w, $y);
        }
        // ln=1 o ln=2: MultiCell ya baja de línea automáticamente
    }
}
