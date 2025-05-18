@extends('layouts.app')

@section('title', 'Predicciones')

@section('content')
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .label-column {
            text-align: left;
        }
        .divider-row {
            border-bottom: 3px solid black;
        }

        .text-porcentaje, .text-escano {
            color: #8c0c34;
            font-weight: bold;
        }
    </style>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    @php
        $predicciones = [];
    @endphp

    <h2>Predicciones para 2027</h2>

    <div style="display: flex; gap: 20px; flex-wrap: wrap;">
        <canvas id="abstencionChart" width="300" height="300"></canvas>
        <canvas id="blancoChart" width="300" height="300"></canvas>
        <canvas id="nuloChart" width="300" height="300"></canvas>
    </div>

    <script>
        const labels = @json($years);

        const abstencionData = @json(array_map(fn($y) => $abstencion[$y][0] ?? null, $years));
        const blancoData = @json(array_map(fn($y) => $blanco[$y][0] ?? null, $years));
        const nuloData = @json(array_map(fn($y) => $nulo[$y][0] ?? null, $years));
        const fontSize = 16
        const baseFontSize = fontSize
        //const baseFontSize = window.innerWidth < 600 ? 10 : fontSize; // Más pequeño en móviles
        const titleSize = baseFontSize + 6
        const tipSize = baseFontSize + 2
        const predictionColor = '#158b00'

        const splitData = (dataArray) => {
            const lastIndex = dataArray.length - 1;
            const real = Array.from(dataArray);
            const pred = new Array(dataArray.length).fill(null);

            // Keep only real data up to penultimate point
            real[lastIndex] = null;

            // Keep prediction only at the last two points (connect penultimate to last)
            pred[lastIndex - 1] = dataArray[lastIndex - 1];
            pred[lastIndex] = dataArray[lastIndex];

            return [real, pred];
        };

        const createChart = (ctxId, label, data, color, colorPred) => {
            const [realData, predData] = splitData(data);

            const ctx = document.getElementById(ctxId).getContext('2d');
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [
                        {
                            label: label + ' (Histórico)',
                            data: realData,
                            backgroundColor: color + '33',
                            borderColor: color,
                            borderWidth: 2,
                            tension: 0.3,
                            fill: true,
                            pointRadius: 5,
                            pointHoverRadius: 7
                        },
                        {
                            label: label + ' (Predicción)',
                            data: predData,
                            backgroundColor: colorPred + '33',
                            borderColor: colorPred,
                            borderDash: [5, 5],
                            borderWidth: 2,
                            tension: 0.3,
                            fill: true,
                            pointRadius: 6,
                            pointHoverRadius: 8
                        }
                    ]
                },
                options: {
                    responsive: true,
                    plugins: {
                        title: {
                            display: true,
                            text: label,
                            font: {
                                size: titleSize // Título más grande
                            }
                        },
                        legend: {
                            display: true,
                            labels: {
                                font: {
                                    size: baseFontSize // Tamaño de la leyenda
                                }
                            }
                        },
                        tooltip: {
                            bodyFont: {
                                size: baseFontSize // Texto en el tooltip
                            },
                            titleFont: {
                                size: tipSize // Título en el tooltip
                            },
                            filter: function(item) {
                                // Oculta la entrada de predicción para el penúltimo año
                                const yearIndex = item.dataIndex;
                                const datasetLabel = item.dataset.label;
                                const isPred = datasetLabel.includes('Predicción');
                                const isPenultimate = yearIndex === (labels.length - 2);

                                return !(isPred && isPenultimate);
                            }
                        }
                    },
                    scales: {
                        x: {
                            ticks: {
                                font: {
                                    size: baseFontSize // Números en eje X
                                }
                            }
                        },
                        y: {
                            beginAtZero: true,
                            ticks: {
                                font: {
                                    size: baseFontSize // Números en eje Y
                                }
                            }
                        }
                    }
                }
            });
        };

        createChart('abstencionChart', 'Abstenciones', abstencionData, '#f39c12', predictionColor);
        createChart('blancoChart', 'Votos en blanco', blancoData, '#2980b9', predictionColor);
        createChart('nuloChart', 'Votos nulos', nuloData, '#c0392b', predictionColor);
    </script>
@endsection
