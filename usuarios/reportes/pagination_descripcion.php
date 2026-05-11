<?php

function paginate($reload, $page, $tpages, $adjacents = 2)
{
    $page      = (int)$page;
    $tpages    = (int)$tpages;
    $adjacents = (int)$adjacents;

    if ($page < 1) $page = 1;
    if ($tpages < 1) $tpages = 1;
    if ($adjacents < 1) $adjacents = 2;

    // Si solo hay una página, no mostrar paginación
    if ($tpages <= 1) {
        return '';
    }

    $prevlabel = '&laquo; Anterior';
    $nextlabel = 'Siguiente &raquo;';

    $out = '<nav aria-label="Paginación">';
    $out .= '<ul class="pagination pagination-sm justify-content-center mb-0">';

    // Botón Anterior
    if ($page > 1) {
        $out .= '<li class="page-item">';
        $out .= '<a class="page-link" href="javascript:void(0);" onclick="load3(' . ($page - 1) . ')">' . $prevlabel . '</a>';
        $out .= '</li>';
    } else {
        $out .= '<li class="page-item disabled">';
        $out .= '<span class="page-link">' . $prevlabel . '</span>';
        $out .= '</li>';
    }

    // Rango de páginas
    $start = max(1, $page - $adjacents);
    $end   = min($tpages, $page + $adjacents);

    // Mostrar página 1 si el rango no empieza ahí
    if ($start > 1) {
        $out .= '<li class="page-item">';
        $out .= '<a class="page-link" href="javascript:void(0);" onclick="load3(1)">1</a>';
        $out .= '</li>';

        if ($start > 2) {
            $out .= '<li class="page-item disabled"><span class="page-link">...</span></li>';
        }
    }

    // Páginas intermedias
    for ($i = $start; $i <= $end; $i++) {
        if ($i == $page) {
            $out .= '<li class="page-item active" aria-current="page">';
            $out .= '<span class="page-link">' . $i . '</span>';
            $out .= '</li>';
        } else {
            $out .= '<li class="page-item">';
            $out .= '<a class="page-link" href="javascript:void(0);" onclick="load3(' . $i . ')">' . $i . '</a>';
            $out .= '</li>';
        }
    }

    // Mostrar última página si el rango no termina ahí
    if ($end < $tpages) {
        if ($end < $tpages - 1) {
            $out .= '<li class="page-item disabled"><span class="page-link">...</span></li>';
        }

        $out .= '<li class="page-item">';
        $out .= '<a class="page-link" href="javascript:void(0);" onclick="load3(' . $tpages . ')">' . $tpages . '</a>';
        $out .= '</li>';
    }

    // Botón Siguiente
    if ($page < $tpages) {
        $out .= '<li class="page-item">';
        $out .= '<a class="page-link" href="javascript:void(0);" onclick="load3(' . ($page + 1) . ')">' . $nextlabel . '</a>';
        $out .= '</li>';
    } else {
        $out .= '<li class="page-item disabled">';
        $out .= '<span class="page-link">' . $nextlabel . '</span>';
        $out .= '</li>';
    }

    $out .= '</ul>';
    $out .= '</nav>';

    return $out;
}
?>