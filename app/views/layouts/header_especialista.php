<?php
require_once BASE_PATH . '/app/helpers/session_especialista.php';
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Control especialista</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha384-…tu-hash…-…" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.3.5/css/dataTables.dataTables.css" />
    <!-- FullCalendar CSS -->
    <link href='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.css' rel='stylesheet' />
    <link rel="stylesheet" href="<?= BASE_URL ?>/public/assets/dashboard/css/styles.css">
</head>
<style>
    /* Personalización de colores para E-VITALIX */
    :root {
        --fc-today-bg-color: rgba(0, 123, 255, 0.1);
        --fc-border-color: #e0e0e0;
    }

    /* Botones del calendario */
    .fc .fc-button-primary {
        background-color: var(--color-primario, #007bff);
        border-color: var(--color-primario, #007bff);
        transition: all 0.3s;
    }

    .fc .fc-button-primary:hover {
        background-color: var(--color-secundario, #0056b3);
        border-color: var(--color-secundario, #0056b3);
    }

    .fc .fc-button-primary:not(:disabled).fc-button-active {
        background-color: var(--color-secundario, #0056b3);
    }

    /* Eventos según estado */
    .fc-event-disponible {
        background-color: #28a745 !important;
        border-color: #28a745 !important;
        cursor: pointer;
    }

    .fc-event-reservado {
        background-color: #007bff !important;
        border-color: #007bff !important;
        cursor: default;
    }

    .fc-event-bloqueado {
        background-color: #6c757d !important;
        border-color: #6c757d !important;
        cursor: not-allowed;
    }

    .fc-event-pendiente {
        background-color: #ffc107 !important;
        border-color: #ffc107 !important;
        cursor: pointer;
    }

    .fc-event-aceptada {
        background-color: #17a2b8 !important;
        border-color: #17a2b8 !important;
    }

    .fc-event-cancelada {
        background-color: #dc3545 !important;
        border-color: #dc3545 !important;
        text-decoration: line-through;
    }

    /* Mejorar legibilidad del texto en eventos */
    .fc-event-title {
        color: white;
        font-weight: 600;
        font-size: 12px;
    }

    /* Hover effect */
    .fc-event:hover {
        opacity: 0.9;
        transform: scale(1.02);
        transition: all 0.2s;
    }

    /* Calendario responsive */
    @media (max-width: 768px) {
        .fc-toolbar {
            flex-direction: column;
            gap: 10px;
        }

        .fc-toolbar-chunk {
            width: 100%;
            display: flex;
            justify-content: center;
        }
    }
</style>