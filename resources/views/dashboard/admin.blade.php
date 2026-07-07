@extends('layouts.app')

@section('content')
    <div class="container-full">
        <div class="row">
            <div class="col s12 l6">
                <h1 class="title">Dashboard</h1>
                <div class="breadcrumbs full-width">
                    <a class="breadcrumb">Sistema de Pedidos Madroño Móvil - {{ App\Models\TblEmpresa::first()->nombre }}</a>
                </div>
            </div>
            
            <div class="col l6 right-align">
                <a class="mdc-button mdc-button--raised mdc-button--large" href="{{ route('pedidos.create') }}">
                    <span class="mdc-button__label mr-1">Nuevo Pedido</span>
                    <i class="fas fa-shopping-cart"></i>
                </a>
            </div>
        </div>
        <div class="row mb-0">
            <div class="col s12">
                <div class="card">
                    <div class="card-content px-0 pb-0">
                        <span class="card-title center mb-3 px-2">Ventas totales de la última semana</span>
                        <div id="pedidos_semana" style="width:100%; height:200px;"></div>
                    </div>
                </div>
            </div>
            <div class="col s12 l6">
                <div class="card">
                    <div class="card-content px-0 pb-0">
                        <span class="card-title center mb-3 px-2">Ventas x Línea de la última semana</span>
                        <div id="lineas_semana" style="width:100%; height:250px;"></div>
                    </div>
                </div>
            </div>
            <div class="col s12 l6">
                <div class="card">
                    <div class="card-content px-0 pb-0">
                        <span class="card-title center mb-3 px-2">Kilos x Línea de la última semana</span>
                        <div id="kilos_linea" style="width:100%; height:250px;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        @forelse($pedidos as $pedido)
        @empty
            <div class="alert">No se han creado pedidos</div>
        @endforelse
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('vendor/highcharts/highcharts.js') }}"></script>
    <script>
        $(document).ready(function(){
            $('#dashboard').addClass('mdc-list-item--active');
            var lineasSemana = @json($lineaSemana);
            var kilosLinea = @json($kilosSemana);

            var pedidosSemanaChart = Highcharts.chart('pedidos_semana', {
                chart: {
                    type: 'line'
                },
                title: {
                    text: ''
                },
                xAxis: {
                    categories: @json($pedidosSemana->pluck('nombre_dia')),
                    labels: {                
                        formatter: function () {
                            return '<span style="text-transform: capitalize">' + this.value + '</span>';
                        }
                    }
                },
                yAxis: {
                    title: {
                        text: 'Total de Ventas'
                    },
                    labels: {                
                        formatter: function () {
                            return '$ ' + numeroMiles(this.value.toFixed(0) / 1000) + 'k';
                        }
                    }
                },
                legend: {
                    enabled: false
                },
                tooltip: {
                    formatter: function () {
                        return this.points.reduce(function (s, point) {
                            return s + '<br/>' + point.series.name + ': ' +
                                '$ ' + numeroMiles(point.y.toFixed(0));
                        }, '<b style="text-transform: capitalize; font-weight: 700;">' + this.x + '</b>');
                    },
                    shared: true
                },
                plotOptions: {
                    line: {
                        dataLabels: {
                            enabled: true,
                            formatter: function () {
                                return '$ ' + numeroMiles(this.y.toFixed(0));
                            }
                        },
                        enableMouseTracking: {
                            enabled: true
                        }
                    }
                },
                series: [{
                    name: 'Ventas',
                    data: @json($pedidosSemana->pluck('total_ventas'))
                }],
                responsive: {
                    rules: [{
                        condition: {
                            maxWidth: 500
                        },
                        chartOptions: {
                            legend: {
                                layout: 'horizontal',
                                align: 'center',
                                verticalAlign: 'bottom'
                            }
                        }
                    }]
                }
            });

            var lineasSemanaChart = Highcharts.chart('lineas_semana', {
                chart: {
                    plotBackgroundColor: null,
                    plotBorderWidth: null,
                    plotShadow: false,
                    type: 'pie'
                },
                title: {
                    text: ''
                },
                tooltip: {
                    formatter: function () {
                        return '<span>' + this.point.name + '<br/><b>$ ' + numeroMiles(parseFloat(this.point.y.toFixed(2))) + ' - ' + numeroMiles(parseFloat(this.point.percentage.toFixed(2))) + '%</b></span>';
                    }
                },
                accessibility: {
                    point: {
                        valueSuffix: '%'
                    }
                },
                plotOptions: {
                    pie: {
                        allowPointSelect: true,
                        cursor: 'pointer',
                        dataLabels: {
                            enabled: true,
                            style:{
                                fontWeight: 'normal'
                            },
                            formatter: function () {
                                return '<span>' + this.point.name + '<br/><b>$ ' + numeroMiles(parseFloat(this.point.y.toFixed(2))) + ' - ' + numeroMiles(parseFloat(this.point.percentage.toFixed(1))) + '%</b></span>';
                            }
                        }
                    }
                },
                series: [{
                    name: 'Ventas x Linea',
                    colorByPoint: true,
                    data: lineasSemana
                }],
                responsive: {
                    rules: [{
                        condition: {
                            maxWidth: 500
                        },
                        chartOptions: {
                            legend: {
                                layout: 'horizontal',
                                align: 'center',
                                verticalAlign: 'bottom'
                            }
                        }
                    }]
                }
            });

            var kilosLineaChart = Highcharts.chart('kilos_linea', {
                chart: {
                    plotBackgroundColor: null,
                    plotBorderWidth: null,
                    plotShadow: false,
                    type: 'pie'
                },
                title: {
                    text: ''
                },
                tooltip: {
                    formatter: function () {
                        return '<span>' + this.point.name + '<br/><b>' + numeroMiles(parseFloat(this.point.y.toFixed(2))) + ' Kg - ' + numeroMiles(parseFloat(this.point.percentage.toFixed(2))) + '%</b></span>';
                    }
                },
                accessibility: {
                    point: {
                        valueSuffix: '%'
                    }
                },
                plotOptions: {
                    pie: {
                        allowPointSelect: true,
                        cursor: 'pointer',
                        dataLabels: {
                            enabled: true,
                            style:{
                                fontWeight: 'normal'
                            },
                            formatter: function () {
                                return '<span>' + this.point.name + '<br/><b>' + numeroMiles(parseFloat(this.point.y.toFixed(2))) + ' Kg - ' + numeroMiles(parseFloat(this.point.percentage.toFixed(2))) + '%</b></span>';
                            }
                        },
                    }
                },
                series: [{
                    name: 'Ventas x Linea',
                    colorByPoint: true,
                    data: kilosLinea
                }],
                responsive: {
                    rules: [{
                        condition: {
                            maxWidth: 500
                        },
                        chartOptions: {
                            legend: {
                                layout: 'horizontal',
                                align: 'center',
                                verticalAlign: 'bottom'
                            }
                        }
                    }]
                }
            });

            // Imprimir número en formato de miles
            function numeroMiles(numero) {
                if (numero) {
                    let numeroStr = numero.toString();
                    let decimales = null;
                    if (numeroStr.indexOf('.') > 0) {
                        decimales = numeroStr.substring(numeroStr.indexOf('.') + 1);
                        numeroStr = numeroStr.substring(0, numeroStr.indexOf('.'));
                    }
                    let numeroFinal = '';
                    for (var j, i = numeroStr.length - 1, j = 0; i >= 0; i-- , j++) {
                        numeroFinal = numeroStr.charAt(i) + ((j > 0) && (j % 3 === 0) ? "." : "") + numeroFinal;
                    }
                    if (decimales) {
                        numeroFinal = numeroFinal + ',' + decimales;
                    }
                    return numeroFinal;
                } else {
                    return 0;
                }
            }

            @if($mostrarMensaje)
                Swal.fire({
                    title: 'Operación Exitosa',
                    text: '{{ $mensaje }}',
                    icon: 'success'
                });
            @endif
        });
    </script>
@endsection