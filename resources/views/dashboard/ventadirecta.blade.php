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
        @if (!$usuario->cliente)
            <div class="col s12">
                <div class="card highlighted bg-primary white-text">
                    <div class="card-content center">
                        <span class="card-title highlighted center mb-1">USUARIO SIN NIT PREDETERMINADO</span>
                        <span class="card-subtitle subtitle-2 highlighted mb-0">Comunícate con departamento de Sistemas para solucionar este problema</span>
                    </div>
                </div>
            </div>
            @endif
            <div class="col s12">
                <div class="card highlighted">
                    <div class="card-content full-height d-flex f-column">
                        <div class="row mb-0">
                            <div class="col s12 m6 mb-1">
                                <span class="card-title highlighted center">Total Pedido</span>
                                @if (count($total_pedidos) > 0)
                                    @foreach ($total_pedidos as $ttl_ped)
                                        <span class="card-title bg-primary white-text py-1 px-1 center" id="total_pedidos">${{ number_format($ttl_ped->total_pedidos, 2, ',', '.') }}</span>
                                    @endforeach
                                @else
                                    <span class="card-title bg-primary white-text py-1 px-1 center" id="total_pedidos">$ 0</span>
                                @endif
                            </div>
                            <div class="col s12 m6 mb-1">
                                <span class="card-title highlighted center">Total Abonado</span>
                                @if ($usuario->abono > 0)
                                    <span class="card-title bg-primary white-text py-1 px-1 center" id="total_abonos">${{ number_format($usuario->abono, 2, ',', '.') }}</span>
                                @else
                                    <span class="card-title bg-primary white-text py-1 px-1 center" id="total_abonos">$ 0</span>
                                @endif
                            </div>
                            <div class="col s12 m6 mb-1">
                                <span class="card-title highlighted center">Total Facturado</span>
                                @if ($usuario->cliente->valor_facturado > 0)
                                    <span class="card-title bg-primary white-text py-1 px-1 center" id="total_abonos">${{ number_format($usuario->cliente->valor_facturado, 2, ',', '.') }}</span>
                                @else
                                    <span class="card-title bg-primary white-text py-1 px-1 center" id="total_abonos">$ 0</span>
                                @endif
                            </div>
                            <div class="col s12 m6 mb-1">
                                <span class="card-title highlighted center">Restante Abono</span>
                                @if ($usuario->abono > 0)
                                    <span class="card-title bg-primary white-text py-1 px-1 center" id="total_abonos">${{ number_format($usuario->abono - $usuario->cliente->valor_facturado, 2, ',', '.') }}</span>
                                @else
                                    <span class="card-title bg-primary white-text py-1 px-1 center" id="total_abonos">$ 0</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col s12">
                <div class="card highlighted">
                    <div class="card-content full-height d-flex f-column justify-content">
                        <span class="card-title highlighted center">Avisos</span>
                        @if (count($avisos) > 0)
                            @foreach ($avisos as $aviso)
                                <span class="card-title bg-primary white-text py-1 px-1" id="valor_pedido">{{ $aviso->aviso }}</span>
                            @endforeach
                        @else
                            <span class="card-title bg-primary white-text py-1 px-1" id="valor_pedido">No hay avisos en este momento.</span>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col s12">
                <div class="card">
                    <div class="card-content px-0 pb-0">
                        <span class="card-title center mb-3 px-2">Ventas totales de la última semana</span>
                        <div id="pedidos_semana" style="width:100%; height:200px;"></div>
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
        });
    </script>
@endsection
