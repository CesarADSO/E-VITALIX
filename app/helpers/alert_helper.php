<?php

/**
 * Función para imprimir SweetAlert dinámico con estilo SENA
 */
function mostrarSweetAlert($tipo, $titulo, $mensaje, $redirect = null)
{
    echo "
    <html>
        <head>
            <meta charset='UTF-8'>
            <style>
                @import url('https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700;800&display=swap');


                body {
                    margin: 0;
                    height: 100vh;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    background: linear-gradient(135deg, #0c498a, #007bff);
                    font-family: 'Montserrat', sans-serif;
                    color: #fff;
                }

                .swal2-popup {
                    font-family: 'Nunito', sans-serif !important;
                }

                .swal2-title {
                    color: #0c498a !important;
                    font-weight: 600 !important;
                }

                .swal2-styled.swal2-confirm {
                    background-color: #007bff !important;
                    border: none !important;
                }

                .swal2-styled.swal2-confirm:hover {
                    background-color: #1a73d3 !important;
                }

                .swal2-styled.swal2-cancel {
                    background-color: #969696 !important;
                }
            </style>
            <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
        </head>
        <body>
            <script>
                Swal.fire({
                    icon: '$tipo',
                    title: '$titulo',
                    text: '$mensaje',
                    confirmButtonText: 'Aceptar',
                    confirmButtonColor: '#007bff',
                    background: '#fff',
                    color: '#0c498a'
                }).then((result) => {
                    " . ($redirect ? "window.location.href = '$redirect';" : "window.history.back();") . "
                });
            </script>
        </body>
    </html>";
}
