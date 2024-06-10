@extends('layouts.main')

@section('body')
    <div class="row">


        <div class="col-lg-4">
            <div class="card card-block card-stretch card-height-helf">
                <div class="card-body" style="position: relative;">
                    <div class="d-flex align-items-top justify-content-between">
                        <div class="">
                            <p class="mb-0">Income</p>
                            <h5>$ 98,7800 K</h5>
                        </div>
                        <div class="card-header-toolbar d-flex align-items-center">
                            <div class="dropdown">
                                <span class="dropdown-toggle dropdown-bg btn" id="dropdownMenuButton003"
                                    data-toggle="dropdown">
                                    This Month<i class="ri-arrow-down-s-line ml-1"></i>
                                </span>
                                <div class="dropdown-menu dropdown-menu-right shadow-none"
                                    aria-labelledby="dropdownMenuButton003">
                                    <a class="dropdown-item" href="#">Year</a>
                                    <a class="dropdown-item" href="#">Month</a>
                                    <a class="dropdown-item" href="#">Week</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="layout1-chart-3" class="layout-chart-1" style="min-height: 150px;">
                        <div id="apexcharts3u92hwlw" class="apexcharts-canvas apexcharts3u92hwlw light"
                            style="width: 882px; height: 150px;"><svg id="SvgjsSvg1169" width="882" height="150"
                                xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink"
                                xmlns:svgjs="http://svgjs.com/svgjs" class="apexcharts-svg" xmlns:data="ApexChartsNS"
                                transform="translate(0, 0)" style="background: transparent;">
                                <g id="SvgjsG1171" class="apexcharts-inner apexcharts-graphical"
                                    transform="translate(0, 15)">
                                    <defs id="SvgjsDefs1170">
                                        <clipPath id="gridRectMask3u92hwlw">
                                            <rect id="SvgjsRect1176" width="885" height="138" x="-1.5" y="-1.5"
                                                rx="0" ry="0" fill="#ffffff" opacity="1" stroke-width="0"
                                                stroke="none" stroke-dasharray="0"></rect>
                                        </clipPath>
                                        <clipPath id="gridRectMarkerMask3u92hwlw">
                                            <rect id="SvgjsRect1177" width="884" height="137" x="-1" y="-1"
                                                rx="0" ry="0" fill="#ffffff" opacity="1" stroke-width="0"
                                                stroke="none" stroke-dasharray="0"></rect>
                                        </clipPath>
                                        <filter id="SvgjsFilter1185" filterUnits="userSpaceOnUse">
                                            <feFlood id="SvgjsFeFlood1186" flood-color="#000000" flood-opacity="0.2"
                                                result="SvgjsFeFlood1186Out" in="SourceGraphic"></feFlood>
                                            <feComposite id="SvgjsFeComposite1187" in="SvgjsFeFlood1186Out"
                                                in2="SourceAlpha" operator="in" result="SvgjsFeComposite1187Out">
                                            </feComposite>
                                            <feOffset id="SvgjsFeOffset1188" dx="1" dy="12"
                                                result="SvgjsFeOffset1188Out" in="SvgjsFeComposite1187Out"></feOffset>
                                            <feGaussianBlur id="SvgjsFeGaussianBlur1189" stdDeviation="2 "
                                                result="SvgjsFeGaussianBlur1189Out" in="SvgjsFeOffset1188Out">
                                            </feGaussianBlur>
                                            <feMerge id="SvgjsFeMerge1190" result="SvgjsFeMerge1190Out" in="SourceGraphic">
                                                <feMergeNode id="SvgjsFeMergeNode1191" in="SvgjsFeGaussianBlur1189Out">
                                                </feMergeNode>
                                                <feMergeNode id="SvgjsFeMergeNode1192" in="[object Arguments]">
                                                </feMergeNode>
                                            </feMerge>
                                            <feBlend id="SvgjsFeBlend1193" in="SourceGraphic" in2="SvgjsFeMerge1190Out"
                                                mode="normal" result="SvgjsFeBlend1193Out">
                                            </feBlend>
                                        </filter>
                                    </defs>
                                    <line id="SvgjsLine1175" x1="0" y1="0" x2="0" y2="135"
                                        stroke="#b6b6b6" stroke-dasharray="3" class="apexcharts-xcrosshairs" x="0" y="0"
                                        width="1" height="135" fill="#b1b9c4" filter="none" fill-opacity="0.9"
                                        stroke-width="1"></line>
                                    <g id="SvgjsG1194" class="apexcharts-xaxis" transform="translate(0, 0)">
                                        <g id="SvgjsG1195" class="apexcharts-xaxis-texts-g" transform="translate(0, -4)">
                                        </g>
                                    </g>
                                    <g id="SvgjsG1198" class="apexcharts-grid">
                                        <line id="SvgjsLine1200" x1="0" y1="135" x2="882"
                                            y2="135" stroke="transparent" stroke-dasharray="0"></line>
                                        <line id="SvgjsLine1199" x1="0" y1="1" x2="0"
                                            y2="135" stroke="transparent" stroke-dasharray="0"></line>
                                    </g>
                                    <g id="SvgjsG1179" class="apexcharts-line-series apexcharts-plot-series">
                                        <g id="SvgjsG1180" class="apexcharts-series" seriesName="Desktops"
                                            data:longestSeries="true" rel="1" data:realIndex="0">
                                            <path id="SvgjsPath1183"
                                                d="M0 97.19999999999999C61.739999999999995 97.19999999999999 114.66000000000001 64.8 176.4 64.8C238.14 64.8 291.06 108 352.8 108C414.54 108 467.46000000000004 37.79999999999998 529.2 37.79999999999998C590.94 37.79999999999998 643.86 70.19999999999999 705.6 70.19999999999999C767.34 70.19999999999999 820.26 16.19999999999999 882 16.19999999999999C882 16.19999999999999 882 16.19999999999999 882 16.19999999999999 "
                                                fill="none" fill-opacity="1" stroke="rgba(255,126,65,0.85)"
                                                stroke-opacity="1" stroke-linecap="butt" stroke-width="3"
                                                stroke-dasharray="0" class="apexcharts-line" index="0"
                                                clip-path="url(#gridRectMask3u92hwlw)" filter="url(#SvgjsFilter1185)"
                                                pathTo="M 0 97.19999999999999C 61.739999999999995 97.19999999999999 114.66000000000001 64.8 176.4 64.8C 238.14 64.8 291.06 108 352.8 108C 414.54 108 467.46000000000004 37.79999999999998 529.2 37.79999999999998C 590.94 37.79999999999998 643.86 70.19999999999999 705.6 70.19999999999999C 767.34 70.19999999999999 820.26 16.19999999999999 882 16.19999999999999"
                                                pathFrom="M -1 189L -1 189L 176.4 189L 352.8 189L 529.2 189L 705.6 189L 882 189">
                                            </path>
                                            <g id="SvgjsG1181" class="apexcharts-series-markers-wrap">
                                                <g class="apexcharts-series-markers">
                                                    <circle id="SvgjsCircle1206" r="0" cx="0" cy="0"
                                                        class="apexcharts-marker w2q018sep no-pointer-events"
                                                        stroke="#ffffff" fill="#ff7e41" fill-opacity="1"
                                                        stroke-width="2" stroke-opacity="0.9" default-marker-size="0">
                                                    </circle>
                                                </g>
                                            </g>
                                            <g id="SvgjsG1182" class="apexcharts-datalabels"></g>
                                        </g>
                                    </g>
                                    <line id="SvgjsLine1201" x1="0" y1="0" x2="882"
                                        y2="0" stroke="#b6b6b6" stroke-dasharray="0" stroke-width="1"
                                        class="apexcharts-ycrosshairs"></line>
                                    <line id="SvgjsLine1202" x1="0" y1="0" x2="882"
                                        y2="0" stroke-dasharray="0" stroke-width="0"
                                        class="apexcharts-ycrosshairs-hidden"></line>
                                    <g id="SvgjsG1203" class="apexcharts-yaxis-annotations"></g>
                                    <g id="SvgjsG1204" class="apexcharts-xaxis-annotations"></g>
                                    <g id="SvgjsG1205" class="apexcharts-point-annotations"></g>
                                </g><text id="SvgjsText1172" font-family="Helvetica, Arial, sans-serif" x="10" y="16"
                                    text-anchor="start" dominant-baseline="auto" font-size="14px" font-weight="regular"
                                    fill="#373d3f" class="apexcharts-title-text"
                                    style="font-family: Helvetica, Arial, sans-serif; opacity: 1;"></text>
                                <rect id="SvgjsRect1174" width="0" height="0" x="0" y="0" rx="0"
                                    ry="0" fill="#fefefe" opacity="1" stroke-width="0" stroke="none"
                                    stroke-dasharray="0"></rect>
                                <g id="SvgjsG1196" class="apexcharts-yaxis" rel="0"
                                    transform="translate(-21, 0)">
                                    <g id="SvgjsG1197" class="apexcharts-yaxis-texts-g"></g>
                                </g>
                            </svg>
                            <div class="apexcharts-legend"></div>
                            <div class="apexcharts-tooltip light">
                                <div class="apexcharts-tooltip-title"
                                    style="font-family: Helvetica, Arial, sans-serif; font-size: 12px;"></div>
                                <div class="apexcharts-tooltip-series-group"><span class="apexcharts-tooltip-marker"
                                        style="background-color: rgb(255, 126, 65);"></span>
                                    <div class="apexcharts-tooltip-text"
                                        style="font-family: Helvetica, Arial, sans-serif; font-size: 12px;">
                                        <div class="apexcharts-tooltip-y-group"><span
                                                class="apexcharts-tooltip-text-label"></span><span
                                                class="apexcharts-tooltip-text-value"></span></div>
                                        <div class="apexcharts-tooltip-z-group"><span
                                                class="apexcharts-tooltip-text-z-label"></span><span
                                                class="apexcharts-tooltip-text-z-value"></span></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="resize-triggers">
                        <div class="expand-trigger">
                            <div style="width: 923px; height: 251px;"></div>
                        </div>
                        <div class="contract-trigger"></div>
                    </div>
                </div>
            </div>
            <div class="card card-block card-stretch card-height-helf">
                <div class="card-body" style="position: relative;">
                    <div class="d-flex align-items-top justify-content-between">
                        <div class="">
                            <p class="mb-0">Expenses</p>
                            <h5>$ 45,8956 K</h5>
                        </div>
                        <div class="card-header-toolbar d-flex align-items-center">
                            <div class="dropdown">
                                <span class="dropdown-toggle dropdown-bg btn" id="dropdownMenuButton004"
                                    data-toggle="dropdown">
                                    This Month<i class="ri-arrow-down-s-line ml-1"></i>
                                </span>
                                <div class="dropdown-menu dropdown-menu-right shadow-none"
                                    aria-labelledby="dropdownMenuButton004">
                                    <a class="dropdown-item" href="#">Year</a>
                                    <a class="dropdown-item" href="#">Month</a>
                                    <a class="dropdown-item" href="#">Week</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="layout1-chart-4" class="layout-chart-2" style="min-height: 150px;">
                        <div id="apexcharts10ngk3yol" class="apexcharts-canvas apexcharts10ngk3yol light"
                            style="width: 882px; height: 150px;"><svg id="SvgjsSvg1357" width="882" height="150"
                                xmlns="http://www.w3.org/2000/svg" version="1.1"
                                xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:svgjs="http://svgjs.com/svgjs"
                                class="apexcharts-svg" xmlns:data="ApexChartsNS" transform="translate(0, 0)"
                                style="background: transparent;">
                                <g id="SvgjsG1359" class="apexcharts-inner apexcharts-graphical"
                                    transform="translate(0, 15)">
                                    <defs id="SvgjsDefs1358">
                                        <clipPath id="gridRectMask10ngk3yol">
                                            <rect id="SvgjsRect1364" width="885" height="138" x="-1.5" y="-1.5"
                                                rx="0" ry="0" fill="#ffffff" opacity="1"
                                                stroke-width="0" stroke="none" stroke-dasharray="0"></rect>
                                        </clipPath>
                                        <clipPath id="gridRectMarkerMask10ngk3yol">
                                            <rect id="SvgjsRect1365" width="884" height="137" x="-1" y="-1"
                                                rx="0" ry="0" fill="#ffffff" opacity="1"
                                                stroke-width="0" stroke="none" stroke-dasharray="0"></rect>
                                        </clipPath>
                                        <filter id="SvgjsFilter1373" filterUnits="userSpaceOnUse">
                                            <feFlood id="SvgjsFeFlood1374" flood-color="#000000" flood-opacity="0.2"
                                                result="SvgjsFeFlood1374Out" in="SourceGraphic"></feFlood>
                                            <feComposite id="SvgjsFeComposite1375" in="SvgjsFeFlood1374Out"
                                                in2="SourceAlpha" operator="in" result="SvgjsFeComposite1375Out">
                                            </feComposite>
                                            <feOffset id="SvgjsFeOffset1376" dx="1" dy="12"
                                                result="SvgjsFeOffset1376Out" in="SvgjsFeComposite1375Out"></feOffset>
                                            <feGaussianBlur id="SvgjsFeGaussianBlur1377" stdDeviation="2 "
                                                result="SvgjsFeGaussianBlur1377Out" in="SvgjsFeOffset1376Out">
                                            </feGaussianBlur>
                                            <feMerge id="SvgjsFeMerge1378" result="SvgjsFeMerge1378Out"
                                                in="SourceGraphic">
                                                <feMergeNode id="SvgjsFeMergeNode1379" in="SvgjsFeGaussianBlur1377Out">
                                                </feMergeNode>
                                                <feMergeNode id="SvgjsFeMergeNode1380" in="[object Arguments]">
                                                </feMergeNode>
                                            </feMerge>
                                            <feBlend id="SvgjsFeBlend1381" in="SourceGraphic" in2="SvgjsFeMerge1378Out"
                                                mode="normal" result="SvgjsFeBlend1381Out">
                                            </feBlend>
                                        </filter>
                                    </defs>
                                    <line id="SvgjsLine1363" x1="881.5" y1="0" x2="881.5"
                                        y2="135" stroke="#b6b6b6" stroke-dasharray="3"
                                        class="apexcharts-xcrosshairs" x="881.5" y="0" width="1" height="135"
                                        fill="#b1b9c4" filter="none" fill-opacity="0.9" stroke-width="1"></line>
                                    <g id="SvgjsG1382" class="apexcharts-xaxis" transform="translate(0, 0)">
                                        <g id="SvgjsG1383" class="apexcharts-xaxis-texts-g" transform="translate(0, -4)">
                                        </g>
                                    </g>
                                    <g id="SvgjsG1386" class="apexcharts-grid">
                                        <line id="SvgjsLine1388" x1="0" y1="135" x2="882"
                                            y2="135" stroke="transparent" stroke-dasharray="0"></line>
                                        <line id="SvgjsLine1387" x1="0" y1="1" x2="0"
                                            y2="135" stroke="transparent" stroke-dasharray="0"></line>
                                    </g>
                                    <g id="SvgjsG1367" class="apexcharts-line-series apexcharts-plot-series">
                                        <g id="SvgjsG1368" class="apexcharts-series" seriesName="Desktops"
                                            data:longestSeries="true" rel="1" data:realIndex="0">
                                            <path id="SvgjsPath1371"
                                                d="M 0 97.19999999999999C 61.739999999999995 97.19999999999999 114.66000000000001 64.8 176.4 64.8C 238.14 64.8 291.06 108 352.8 108C 414.54 108 467.46000000000004 37.79999999999998 529.2 37.79999999999998C 590.94 37.79999999999998 643.86 70.19999999999999 705.6 70.19999999999999C 767.34 70.19999999999999 820.26 16.19999999999999 882 16.19999999999999"
                                                fill="none" fill-opacity="1" stroke="rgba(50,189,234,0.85)"
                                                stroke-opacity="1" stroke-linecap="butt" stroke-width="3"
                                                stroke-dasharray="0" class="apexcharts-line" index="0"
                                                clip-path="url(#gridRectMask10ngk3yol)" filter="url(#SvgjsFilter1373)"
                                                pathTo="M 0 97.19999999999999C 61.739999999999995 97.19999999999999 114.66000000000001 64.8 176.4 64.8C 238.14 64.8 291.06 108 352.8 108C 414.54 108 467.46000000000004 37.79999999999998 529.2 37.79999999999998C 590.94 37.79999999999998 643.86 70.19999999999999 705.6 70.19999999999999C 767.34 70.19999999999999 820.26 16.19999999999999 882 16.19999999999999"
                                                pathFrom="M -1 189L -1 189L 176.4 189L 352.8 189L 529.2 189L 705.6 189L 882 189">
                                            </path>
                                            <g id="SvgjsG1369" class="apexcharts-series-markers-wrap">
                                                <g class="apexcharts-series-markers">
                                                    <circle id="SvgjsCircle1394" r="0" cx="882"
                                                        cy="16.19999999999999"
                                                        class="apexcharts-marker wghga279r no-pointer-events"
                                                        stroke="#ffffff" fill="#32bdea" fill-opacity="1"
                                                        stroke-width="2" stroke-opacity="0.9" default-marker-size="0">
                                                    </circle>
                                                </g>
                                            </g>
                                            <g id="SvgjsG1370" class="apexcharts-datalabels"></g>
                                        </g>
                                    </g>
                                    <line id="SvgjsLine1389" x1="0" y1="0" x2="882"
                                        y2="0" stroke="#b6b6b6" stroke-dasharray="0" stroke-width="1"
                                        class="apexcharts-ycrosshairs"></line>
                                    <line id="SvgjsLine1390" x1="0" y1="0" x2="882"
                                        y2="0" stroke-dasharray="0" stroke-width="0"
                                        class="apexcharts-ycrosshairs-hidden"></line>
                                    <g id="SvgjsG1391" class="apexcharts-yaxis-annotations"></g>
                                    <g id="SvgjsG1392" class="apexcharts-xaxis-annotations"></g>
                                    <g id="SvgjsG1393" class="apexcharts-point-annotations"></g>
                                </g><text id="SvgjsText1360" font-family="Helvetica, Arial, sans-serif" x="10" y="16"
                                    text-anchor="start" dominant-baseline="auto" font-size="14px" font-weight="regular"
                                    fill="#373d3f" class="apexcharts-title-text"
                                    style="font-family: Helvetica, Arial, sans-serif; opacity: 1;"></text>
                                <rect id="SvgjsRect1362" width="0" height="0" x="0" y="0" rx="0"
                                    ry="0" fill="#fefefe" opacity="1" stroke-width="0" stroke="none"
                                    stroke-dasharray="0"></rect>
                                <g id="SvgjsG1384" class="apexcharts-yaxis" rel="0"
                                    transform="translate(-21, 0)">
                                    <g id="SvgjsG1385" class="apexcharts-yaxis-texts-g"></g>
                                </g>
                            </svg>
                            <div class="apexcharts-legend"></div>
                            <div class="apexcharts-tooltip light" style="left: 753.35px; top: 19.2px;">
                                <div class="apexcharts-tooltip-title"
                                    style="font-family: Helvetica, Arial, sans-serif; font-size: 12px;">Jun</div>
                                <div class="apexcharts-tooltip-series-group active" style="display: flex;"><span
                                        class="apexcharts-tooltip-marker"
                                        style="background-color: rgb(50, 189, 234);"></span>
                                    <div class="apexcharts-tooltip-text"
                                        style="font-family: Helvetica, Arial, sans-serif; font-size: 12px;">
                                        <div class="apexcharts-tooltip-y-group"><span
                                                class="apexcharts-tooltip-text-label">Desktops: </span><span
                                                class="apexcharts-tooltip-text-value">32</span></div>
                                        <div class="apexcharts-tooltip-z-group"><span
                                                class="apexcharts-tooltip-text-z-label"></span><span
                                                class="apexcharts-tooltip-text-z-value"></span></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="resize-triggers">
                        <div class="expand-trigger">
                            <div style="width: 923px; height: 251px;"></div>
                        </div>
                        <div class="contract-trigger"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-8">
            <div class="card card-block card-stretch card-height">
                <div class="card-header d-flex justify-content-between">
                    <div class="header-title">
                        <h4 class="card-title">Order Summary</h4>
                    </div>
                    <div class="card-header-toolbar d-flex align-items-center">
                        <div class="dropdown">
                            <span class="dropdown-toggle dropdown-bg btn" id="dropdownMenuButton005"
                                data-toggle="dropdown">
                                This Month<i class="ri-arrow-down-s-line ml-1"></i>
                            </span>
                            <div class="dropdown-menu dropdown-menu-right shadow-none"
                                aria-labelledby="dropdownMenuButton005">
                                <a class="dropdown-item" href="#">Year</a>
                                <a class="dropdown-item" href="#">Month</a>
                                <a class="dropdown-item" href="#">Week</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="d-flex flex-wrap align-items-center mt-2">
                        <div class="d-flex align-items-center progress-order-left">
                            <div class="progress progress-round m-0 orange conversation-bar" data-percent="46">
                                <span class="progress-left">
                                    <span class="progress-bar"></span>
                                </span>
                                <span class="progress-right">
                                    <span class="progress-bar"></span>
                                </span>
                                <div class="progress-value text-secondary">46%</div>
                            </div>
                            <div class="progress-value ml-3 pr-5 border-right">
                                <h5>$12,6598</h5>
                                <p class="mb-0">Average Orders</p>
                            </div>
                        </div>
                        <div class="d-flex align-items-center ml-5 progress-order-right">
                            <div class="progress progress-round m-0 primary conversation-bar" data-percent="46">
                                <span class="progress-left">
                                    <span class="progress-bar"></span>
                                </span>
                                <span class="progress-right">
                                    <span class="progress-bar"></span>
                                </span>
                                <div class="progress-value text-primary">46%</div>
                            </div>
                            <div class="progress-value ml-3">
                                <h5>$59,8478</h5>
                                <p class="mb-0">Top Orders</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body pt-0" style="position: relative;">
                    <div id="layout1-chart-5" style="min-height: 315px;">
                        <div id="apexchartscxlo9j0pi" class="apexcharts-canvas apexchartscxlo9j0pi light"
                            style="width: 882px; height: 300px;"><svg id="SvgjsSvg1245" width="882" height="300"
                                xmlns="http://www.w3.org/2000/svg" version="1.1"
                                xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:svgjs="http://svgjs.com/svgjs"
                                class="apexcharts-svg" xmlns:data="ApexChartsNS" transform="translate(0, 0)"
                                style="background: transparent;">
                                <foreignObject x="0" y="0" width="882" height="300">
                                    <div class="apexcharts-legend center position-bottom"
                                        xmlns="http://www.w3.org/1999/xhtml"
                                        style="inset: auto 0px 10px; position: absolute;">
                                        <div class="apexcharts-legend-series" rel="1" data:collapsed="false"
                                            style="margin: 0px 5px;"><span class="apexcharts-legend-marker"
                                                rel="1" data:collapsed="false"
                                                style="background: rgb(50, 189, 234); color: rgb(50, 189, 234); height: 12px; width: 12px; left: 0px; top: 0px; border-width: 0px; border-color: rgb(255, 255, 255); border-radius: 2px;"></span><span
                                                class="apexcharts-legend-text" rel="1" i="0"
                                                data:default-text="Total%20Likes" data:collapsed="false"
                                                style="color: rgb(55, 61, 63); font-size: 12px; font-family: Helvetica, Arial, sans-serif;">Total
                                                Likes</span></div>
                                        <div class="apexcharts-legend-series" rel="2" data:collapsed="false"
                                            style="margin: 0px 5px;"><span class="apexcharts-legend-marker"
                                                rel="2" data:collapsed="false"
                                                style="background: rgb(255, 126, 65); color: rgb(255, 126, 65); height: 12px; width: 12px; left: 0px; top: 0px; border-width: 0px; border-color: rgb(255, 255, 255); border-radius: 2px;"></span><span
                                                class="apexcharts-legend-text" rel="2" i="1"
                                                data:default-text="Total%20Share" data:collapsed="false"
                                                style="color: rgb(55, 61, 63); font-size: 12px; font-family: Helvetica, Arial, sans-serif;">Total
                                                Share</span></div>
                                    </div>
                                    <style type="text/css">
                                        .apexcharts-legend {
                                            display: flex;
                                            overflow: auto;
                                            padding: 0 10px;
                                        }

                                        .apexcharts-legend.position-bottom,
                                        .apexcharts-legend.position-top {
                                            flex-wrap: wrap
                                        }

                                        .apexcharts-legend.position-right,
                                        .apexcharts-legend.position-left {
                                            flex-direction: column;
                                            bottom: 0;
                                        }

                                        .apexcharts-legend.position-bottom.left,
                                        .apexcharts-legend.position-top.left,
                                        .apexcharts-legend.position-right,
                                        .apexcharts-legend.position-left {
                                            justify-content: flex-start;
                                        }

                                        .apexcharts-legend.position-bottom.center,
                                        .apexcharts-legend.position-top.center {
                                            justify-content: center;
                                        }

                                        .apexcharts-legend.position-bottom.right,
                                        .apexcharts-legend.position-top.right {
                                            justify-content: flex-end;
                                        }

                                        .apexcharts-legend-series {
                                            cursor: pointer;
                                            line-height: normal;
                                        }

                                        .apexcharts-legend.position-bottom .apexcharts-legend-series,
                                        .apexcharts-legend.position-top .apexcharts-legend-series {
                                            display: flex;
                                            align-items: center;
                                        }

                                        .apexcharts-legend-text {
                                            position: relative;
                                            font-size: 14px;
                                        }

                                        .apexcharts-legend-text *,
                                        .apexcharts-legend-marker * {
                                            pointer-events: none;
                                        }

                                        .apexcharts-legend-marker {
                                            position: relative;
                                            display: inline-block;
                                            cursor: pointer;
                                            margin-right: 3px;
                                        }

                                        .apexcharts-legend.right .apexcharts-legend-series,
                                        .apexcharts-legend.left .apexcharts-legend-series {
                                            display: inline-block;
                                        }

                                        .apexcharts-legend-series.no-click {
                                            cursor: auto;
                                        }

                                        .apexcharts-legend .apexcharts-hidden-zero-series,
                                        .apexcharts-legend .apexcharts-hidden-null-series {
                                            display: none !important;
                                        }

                                        .inactive-legend {
                                            opacity: 0.45;
                                        }
                                    </style>
                                </foreignObject>
                                <g id="SvgjsG1247" class="apexcharts-inner apexcharts-graphical"
                                    transform="translate(32, 40)">
                                    <defs id="SvgjsDefs1246">
                                        <linearGradient id="SvgjsLinearGradient1250" x1="0" y1="0"
                                            x2="0" y2="1">
                                            <stop id="SvgjsStop1251" stop-opacity="0.4"
                                                stop-color="rgba(216,227,240,0.4)" offset="0"></stop>
                                            <stop id="SvgjsStop1252" stop-opacity="0.5"
                                                stop-color="rgba(190,209,230,0.5)" offset="1"></stop>
                                            <stop id="SvgjsStop1253" stop-opacity="0.5"
                                                stop-color="rgba(190,209,230,0.5)" offset="1"></stop>
                                        </linearGradient>
                                        <clipPath id="gridRectMaskcxlo9j0pi">
                                            <rect id="SvgjsRect1255" width="843" height="207.39519900131225" x="-1.5"
                                                y="-1.5" rx="0" ry="0" fill="#ffffff" opacity="1"
                                                stroke-width="0" stroke="none" stroke-dasharray="0">
                                            </rect>
                                        </clipPath>
                                        <clipPath id="gridRectMarkerMaskcxlo9j0pi">
                                            <rect id="SvgjsRect1256" width="842" height="206.39519900131225" x="-1"
                                                y="-1" rx="0" ry="0" fill="#ffffff" opacity="1"
                                                stroke-width="0" stroke="none" stroke-dasharray="0"></rect>
                                        </clipPath>
                                    </defs>
                                    <rect id="SvgjsRect1254" width="10.5" height="204.39519900131225" x="0" y="0"
                                        rx="0" ry="0" fill="url(#SvgjsLinearGradient1250)"
                                        opacity="1" stroke-width="0" stroke-dasharray="3"
                                        class="apexcharts-xcrosshairs" y2="204.39519900131225" filter="none"
                                        fill-opacity="0.9"></rect>
                                    <g id="SvgjsG1287" class="apexcharts-xaxis" transform="translate(0, 0)">
                                        <g id="SvgjsG1288" class="apexcharts-xaxis-texts-g" transform="translate(0, -4)">
                                            <text id="SvgjsText1289" font-family="Helvetica, Arial, sans-serif" x="35"
                                                y="233.39519900131225" text-anchor="middle" dominant-baseline="auto"
                                                font-size="12px" font-weight="400" fill="#373d3f"
                                                class="apexcharts-xaxis-label "
                                                style="font-family: Helvetica, Arial, sans-serif;">
                                                <tspan id="SvgjsTspan1290"
                                                    style="font-family: Helvetica, Arial, sans-serif;">Jan</tspan>
                                                <title>Jan</title>
                                            </text><text id="SvgjsText1291" font-family="Helvetica, Arial, sans-serif"
                                                x="105" y="233.39519900131225" text-anchor="middle"
                                                dominant-baseline="auto" font-size="12px" font-weight="400"
                                                fill="#373d3f" class="apexcharts-xaxis-label "
                                                style="font-family: Helvetica, Arial, sans-serif;">
                                                <tspan id="SvgjsTspan1292"
                                                    style="font-family: Helvetica, Arial, sans-serif;">Feb</tspan>
                                                <title>Feb</title>
                                            </text><text id="SvgjsText1293" font-family="Helvetica, Arial, sans-serif"
                                                x="175" y="233.39519900131225" text-anchor="middle"
                                                dominant-baseline="auto" font-size="12px" font-weight="400"
                                                fill="#373d3f" class="apexcharts-xaxis-label "
                                                style="font-family: Helvetica, Arial, sans-serif;">
                                                <tspan id="SvgjsTspan1294"
                                                    style="font-family: Helvetica, Arial, sans-serif;">Mar</tspan>
                                                <title>Mar</title>
                                            </text><text id="SvgjsText1295" font-family="Helvetica, Arial, sans-serif"
                                                x="245" y="233.39519900131225" text-anchor="middle"
                                                dominant-baseline="auto" font-size="12px" font-weight="400"
                                                fill="#373d3f" class="apexcharts-xaxis-label "
                                                style="font-family: Helvetica, Arial, sans-serif;">
                                                <tspan id="SvgjsTspan1296"
                                                    style="font-family: Helvetica, Arial, sans-serif;">Apr</tspan>
                                                <title>Apr</title>
                                            </text><text id="SvgjsText1297" font-family="Helvetica, Arial, sans-serif"
                                                x="315" y="233.39519900131225" text-anchor="middle"
                                                dominant-baseline="auto" font-size="12px" font-weight="400"
                                                fill="#373d3f" class="apexcharts-xaxis-label "
                                                style="font-family: Helvetica, Arial, sans-serif;">
                                                <tspan id="SvgjsTspan1298"
                                                    style="font-family: Helvetica, Arial, sans-serif;">May</tspan>
                                                <title>May</title>
                                            </text><text id="SvgjsText1299" font-family="Helvetica, Arial, sans-serif"
                                                x="385" y="233.39519900131225" text-anchor="middle"
                                                dominant-baseline="auto" font-size="12px" font-weight="400"
                                                fill="#373d3f" class="apexcharts-xaxis-label "
                                                style="font-family: Helvetica, Arial, sans-serif;">
                                                <tspan id="SvgjsTspan1300"
                                                    style="font-family: Helvetica, Arial, sans-serif;">Jun</tspan>
                                                <title>Jun</title>
                                            </text><text id="SvgjsText1301" font-family="Helvetica, Arial, sans-serif"
                                                x="455" y="233.39519900131225" text-anchor="middle"
                                                dominant-baseline="auto" font-size="12px" font-weight="400"
                                                fill="#373d3f" class="apexcharts-xaxis-label "
                                                style="font-family: Helvetica, Arial, sans-serif;">
                                                <tspan id="SvgjsTspan1302"
                                                    style="font-family: Helvetica, Arial, sans-serif;">Jul</tspan>
                                                <title>Jul</title>
                                            </text><text id="SvgjsText1303" font-family="Helvetica, Arial, sans-serif"
                                                x="525" y="233.39519900131225" text-anchor="middle"
                                                dominant-baseline="auto" font-size="12px" font-weight="400"
                                                fill="#373d3f" class="apexcharts-xaxis-label "
                                                style="font-family: Helvetica, Arial, sans-serif;">
                                                <tspan id="SvgjsTspan1304"
                                                    style="font-family: Helvetica, Arial, sans-serif;">Aug</tspan>
                                                <title>Aug</title>
                                            </text><text id="SvgjsText1305" font-family="Helvetica, Arial, sans-serif"
                                                x="595" y="233.39519900131225" text-anchor="middle"
                                                dominant-baseline="auto" font-size="12px" font-weight="400"
                                                fill="#373d3f" class="apexcharts-xaxis-label "
                                                style="font-family: Helvetica, Arial, sans-serif;">
                                                <tspan id="SvgjsTspan1306"
                                                    style="font-family: Helvetica, Arial, sans-serif;">Sep</tspan>
                                                <title>Sep</title>
                                            </text><text id="SvgjsText1307" font-family="Helvetica, Arial, sans-serif"
                                                x="665" y="233.39519900131225" text-anchor="middle"
                                                dominant-baseline="auto" font-size="12px" font-weight="400"
                                                fill="#373d3f" class="apexcharts-xaxis-label "
                                                style="font-family: Helvetica, Arial, sans-serif;">
                                                <tspan id="SvgjsTspan1308"
                                                    style="font-family: Helvetica, Arial, sans-serif;">Oct</tspan>
                                                <title>Oct</title>
                                            </text><text id="SvgjsText1309" font-family="Helvetica, Arial, sans-serif"
                                                x="735" y="233.39519900131225" text-anchor="middle"
                                                dominant-baseline="auto" font-size="12px" font-weight="400"
                                                fill="#373d3f" class="apexcharts-xaxis-label "
                                                style="font-family: Helvetica, Arial, sans-serif;">
                                                <tspan id="SvgjsTspan1310"
                                                    style="font-family: Helvetica, Arial, sans-serif;">Nov</tspan>
                                                <title>Nov</title>
                                            </text><text id="SvgjsText1311" font-family="Helvetica, Arial, sans-serif"
                                                x="805" y="233.39519900131225" text-anchor="middle"
                                                dominant-baseline="auto" font-size="12px" font-weight="400"
                                                fill="#373d3f" class="apexcharts-xaxis-label "
                                                style="font-family: Helvetica, Arial, sans-serif;">
                                                <tspan id="SvgjsTspan1312"
                                                    style="font-family: Helvetica, Arial, sans-serif;">Dec</tspan>
                                                <title>Dec</title>
                                            </text>
                                        </g>
                                        <line id="SvgjsLine1313" x1="0" y1="205.39519900131225" x2="840"
                                            y2="205.39519900131225" stroke="#78909c" stroke-dasharray="0"
                                            stroke-width="1"></line>
                                    </g>
                                    <g id="SvgjsG1322" class="apexcharts-grid">
                                        <g id="SvgjsG1323" class="apexcharts-gridlines-horizontal">
                                            <line id="SvgjsLine1336" x1="0" y1="0" x2="840"
                                                y2="0" stroke="#e0e0e0" stroke-dasharray="0"
                                                class="apexcharts-gridline"></line>
                                            <line id="SvgjsLine1337" x1="0" y1="40.87903980026245"
                                                x2="840" y2="40.87903980026245" stroke="#e0e0e0"
                                                stroke-dasharray="0" class="apexcharts-gridline"></line>
                                            <line id="SvgjsLine1338" x1="0" y1="81.7580796005249" x2="840"
                                                y2="81.7580796005249" stroke="#e0e0e0" stroke-dasharray="0"
                                                class="apexcharts-gridline"></line>
                                            <line id="SvgjsLine1339" x1="0" y1="122.63711940078734"
                                                x2="840" y2="122.63711940078734" stroke="#e0e0e0"
                                                stroke-dasharray="0" class="apexcharts-gridline"></line>
                                            <line id="SvgjsLine1340" x1="0" y1="163.5161592010498"
                                                x2="840" y2="163.5161592010498" stroke="#e0e0e0"
                                                stroke-dasharray="0" class="apexcharts-gridline"></line>
                                            <line id="SvgjsLine1341" x1="0" y1="204.39519900131222"
                                                x2="840" y2="204.39519900131222" stroke="#e0e0e0"
                                                stroke-dasharray="0" class="apexcharts-gridline"></line>
                                        </g>
                                        <g id="SvgjsG1324" class="apexcharts-gridlines-vertical"></g>
                                        <line id="SvgjsLine1325" x1="70" y1="205.39519900131225" x2="70"
                                            y2="211.39519900131225" stroke="#78909c" stroke-dasharray="0"
                                            class="apexcharts-xaxis-tick"></line>
                                        <line id="SvgjsLine1326" x1="140" y1="205.39519900131225" x2="140"
                                            y2="211.39519900131225" stroke="#78909c" stroke-dasharray="0"
                                            class="apexcharts-xaxis-tick"></line>
                                        <line id="SvgjsLine1327" x1="210" y1="205.39519900131225" x2="210"
                                            y2="211.39519900131225" stroke="#78909c" stroke-dasharray="0"
                                            class="apexcharts-xaxis-tick"></line>
                                        <line id="SvgjsLine1328" x1="280" y1="205.39519900131225" x2="280"
                                            y2="211.39519900131225" stroke="#78909c" stroke-dasharray="0"
                                            class="apexcharts-xaxis-tick"></line>
                                        <line id="SvgjsLine1329" x1="350" y1="205.39519900131225" x2="350"
                                            y2="211.39519900131225" stroke="#78909c" stroke-dasharray="0"
                                            class="apexcharts-xaxis-tick"></line>
                                        <line id="SvgjsLine1330" x1="420" y1="205.39519900131225" x2="420"
                                            y2="211.39519900131225" stroke="#78909c" stroke-dasharray="0"
                                            class="apexcharts-xaxis-tick"></line>
                                        <line id="SvgjsLine1331" x1="490" y1="205.39519900131225" x2="490"
                                            y2="211.39519900131225" stroke="#78909c" stroke-dasharray="0"
                                            class="apexcharts-xaxis-tick"></line>
                                        <line id="SvgjsLine1332" x1="560" y1="205.39519900131225" x2="560"
                                            y2="211.39519900131225" stroke="#78909c" stroke-dasharray="0"
                                            class="apexcharts-xaxis-tick"></line>
                                        <line id="SvgjsLine1333" x1="630" y1="205.39519900131225" x2="630"
                                            y2="211.39519900131225" stroke="#78909c" stroke-dasharray="0"
                                            class="apexcharts-xaxis-tick"></line>
                                        <line id="SvgjsLine1334" x1="700" y1="205.39519900131225" x2="700"
                                            y2="211.39519900131225" stroke="#78909c" stroke-dasharray="0"
                                            class="apexcharts-xaxis-tick"></line>
                                        <line id="SvgjsLine1335" x1="770" y1="205.39519900131225" x2="770"
                                            y2="211.39519900131225" stroke="#78909c" stroke-dasharray="0"
                                            class="apexcharts-xaxis-tick"></line>
                                        <line id="SvgjsLine1343" x1="0" y1="204.39519900131225" x2="840"
                                            y2="204.39519900131225" stroke="transparent" stroke-dasharray="0"></line>
                                        <line id="SvgjsLine1342" x1="0" y1="1" x2="0"
                                            y2="204.39519900131225" stroke="transparent" stroke-dasharray="0"></line>
                                    </g>
                                    <g id="SvgjsG1258" class="apexcharts-bar-series apexcharts-plot-series">
                                        <g id="SvgjsG1259" class="apexcharts-series" rel="1"
                                            seriesName="TotalxLikes" data:realIndex="0">
                                            <path id="SvgjsPath1261"
                                                d="M24.5 204.39519900131225L24.5 29.740327860183726C27 28.240327860183726 29.5 28.240327860183726 32 29.740327860183726L32 204.39519900131225L23 204.39519900131225 "
                                                fill="rgba(50,189,234,1)" fill-opacity="1" stroke="transparent"
                                                stroke-opacity="1" stroke-linecap="butt" stroke-width="3"
                                                stroke-dasharray="0" class="apexcharts-bar-area" index="0"
                                                clip-path="url(#gridRectMaskcxlo9j0pi)"
                                                pathTo="M 24.5 204.39519900131225L 24.5 29.740327860183726Q 28.25 27.490327860183726 32 29.740327860183726L 32 204.39519900131225L 23 204.39519900131225"
                                                pathFrom="M 24.5 204.39519900131225L 24.5 204.39519900131225L 32 204.39519900131225L 32 204.39519900131225L 23 204.39519900131225"
                                                cy="28.615327860183726" cx="93" j="0" val="86"
                                                barHeight="175.77987114112852" barWidth="10.5"></path>
                                            <path id="SvgjsPath1262"
                                                d="M94.5 204.39519900131225L94.5 42.00403980026246C97 40.50403980026246 99.5 40.50403980026246 102 42.00403980026246L102 204.39519900131225L93 204.39519900131225 "
                                                fill="rgba(50,189,234,1)" fill-opacity="1" stroke="transparent"
                                                stroke-opacity="1" stroke-linecap="butt" stroke-width="3"
                                                stroke-dasharray="0" class="apexcharts-bar-area" index="0"
                                                clip-path="url(#gridRectMaskcxlo9j0pi)"
                                                pathTo="M 94.5 204.39519900131225L 94.5 42.00403980026246Q 98.25 39.75403980026246 102 42.00403980026246L 102 204.39519900131225L 93 204.39519900131225"
                                                pathFrom="M 94.5 204.39519900131225L 94.5 204.39519900131225L 102 204.39519900131225L 102 204.39519900131225L 93 204.39519900131225"
                                                cy="40.87903980026246" cx="163" j="1" val="80"
                                                barHeight="163.5161592010498" barWidth="10.5"></path>
                                            <path id="SvgjsPath1263"
                                                d="M164.5 204.39519900131225L164.5 33.82823184020998C167 32.32823184020998 169.5 32.32823184020998 172 33.82823184020998L172 204.39519900131225L163 204.39519900131225 "
                                                fill="rgba(50,189,234,1)" fill-opacity="1" stroke="transparent"
                                                stroke-opacity="1" stroke-linecap="butt" stroke-width="3"
                                                stroke-dasharray="0" class="apexcharts-bar-area" index="0"
                                                clip-path="url(#gridRectMaskcxlo9j0pi)"
                                                pathTo="M 164.5 204.39519900131225L 164.5 33.82823184020998Q 168.25 31.57823184020998 172 33.82823184020998L 172 204.39519900131225L 163 204.39519900131225"
                                                pathFrom="M 164.5 204.39519900131225L 164.5 204.39519900131225L 172 204.39519900131225L 172 204.39519900131225L 163 204.39519900131225"
                                                cy="32.70323184020998" cx="233" j="2" val="84"
                                                barHeight="171.69196716110227" barWidth="10.5"></path>
                                            <path id="SvgjsPath1264"
                                                d="M234.5 204.39519900131225L234.5 11.344759950065622C237 9.844759950065622 239.5 9.844759950065622 242 11.344759950065622L242 204.39519900131225L233 204.39519900131225 "
                                                fill="rgba(50,189,234,1)" fill-opacity="1" stroke="transparent"
                                                stroke-opacity="1" stroke-linecap="butt" stroke-width="3"
                                                stroke-dasharray="0" class="apexcharts-bar-area" index="0"
                                                clip-path="url(#gridRectMaskcxlo9j0pi)"
                                                pathTo="M 234.5 204.39519900131225L 234.5 11.344759950065622Q 238.25 9.094759950065622 242 11.344759950065622L 242 204.39519900131225L 233 204.39519900131225"
                                                pathFrom="M 234.5 204.39519900131225L 234.5 204.39519900131225L 242 204.39519900131225L 242 204.39519900131225L 233 204.39519900131225"
                                                cy="10.219759950065622" cx="303" j="3" val="95"
                                                barHeight="194.17543905124663" barWidth="10.5"></path>
                                            <path id="SvgjsPath1265"
                                                d="M304.5 204.39519900131225L304.5 35.87218383022309C307 34.37218383022309 309.5 34.37218383022309 312 35.87218383022309L312 204.39519900131225L303 204.39519900131225 "
                                                fill="rgba(50,189,234,1)" fill-opacity="1" stroke="transparent"
                                                stroke-opacity="1" stroke-linecap="butt" stroke-width="3"
                                                stroke-dasharray="0" class="apexcharts-bar-area" index="0"
                                                clip-path="url(#gridRectMaskcxlo9j0pi)"
                                                pathTo="M 304.5 204.39519900131225L 304.5 35.87218383022309Q 308.25 33.62218383022309 312 35.87218383022309L 312 204.39519900131225L 303 204.39519900131225"
                                                pathFrom="M 304.5 204.39519900131225L 304.5 204.39519900131225L 312 204.39519900131225L 312 204.39519900131225L 303 204.39519900131225"
                                                cy="34.74718383022309" cx="373" j="4" val="83"
                                                barHeight="169.64801517108916" barWidth="10.5"></path>
                                            <path id="SvgjsPath1266"
                                                d="M374.5 204.39519900131225L374.5 52.223799750328084C377 50.723799750328084 379.5 50.723799750328084 382 52.223799750328084L382 204.39519900131225L373 204.39519900131225 "
                                                fill="rgba(50,189,234,1)" fill-opacity="1" stroke="transparent"
                                                stroke-opacity="1" stroke-linecap="butt" stroke-width="3"
                                                stroke-dasharray="0" class="apexcharts-bar-area" index="0"
                                                clip-path="url(#gridRectMaskcxlo9j0pi)"
                                                pathTo="M 374.5 204.39519900131225L 374.5 52.223799750328084Q 378.25 49.973799750328084 382 52.223799750328084L 382 204.39519900131225L 373 204.39519900131225"
                                                pathFrom="M 374.5 204.39519900131225L 374.5 204.39519900131225L 382 204.39519900131225L 382 204.39519900131225L 373 204.39519900131225"
                                                cy="51.098799750328084" cx="443" j="5" val="75"
                                                barHeight="153.29639925098417" barWidth="10.5"></path>
                                            <path id="SvgjsPath1267"
                                                d="M444.5 204.39519900131225L444.5 25.65242388015747C447 24.15242388015747 449.5 24.15242388015747 452 25.65242388015747L452 204.39519900131225L443 204.39519900131225 "
                                                fill="rgba(50,189,234,1)" fill-opacity="1" stroke="transparent"
                                                stroke-opacity="1" stroke-linecap="butt" stroke-width="3"
                                                stroke-dasharray="0" class="apexcharts-bar-area" index="0"
                                                clip-path="url(#gridRectMaskcxlo9j0pi)"
                                                pathTo="M 444.5 204.39519900131225L 444.5 25.65242388015747Q 448.25 23.40242388015747 452 25.65242388015747L 452 204.39519900131225L 443 204.39519900131225"
                                                pathFrom="M 444.5 204.39519900131225L 444.5 204.39519900131225L 452 204.39519900131225L 452 204.39519900131225L 443 204.39519900131225"
                                                cy="24.52742388015747" cx="513" j="6" val="88"
                                                barHeight="179.86777512115478" barWidth="10.5"></path>
                                            <path id="SvgjsPath1268"
                                                d="M514.5 204.39519900131225L514.5 50.17984776031494C517 48.67984776031494 519.5 48.67984776031494 522 50.17984776031494L522 204.39519900131225L513 204.39519900131225 "
                                                fill="rgba(50,189,234,1)" fill-opacity="1" stroke="transparent"
                                                stroke-opacity="1" stroke-linecap="butt" stroke-width="3"
                                                stroke-dasharray="0" class="apexcharts-bar-area" index="0"
                                                clip-path="url(#gridRectMaskcxlo9j0pi)"
                                                pathTo="M 514.5 204.39519900131225L 514.5 50.17984776031494Q 518.25 47.92984776031494 522 50.17984776031494L 522 204.39519900131225L 513 204.39519900131225"
                                                pathFrom="M 514.5 204.39519900131225L 514.5 204.39519900131225L 522 204.39519900131225L 522 204.39519900131225L 513 204.39519900131225"
                                                cy="49.05484776031494" cx="583" j="7" val="76"
                                                barHeight="155.3403512409973" barWidth="10.5"></path>
                                            <path id="SvgjsPath1269"
                                                d="M584.5 204.39519900131225L584.5 29.740327860183726C587 28.240327860183726 589.5 28.240327860183726 592 29.740327860183726L592 204.39519900131225L583 204.39519900131225 "
                                                fill="rgba(50,189,234,1)" fill-opacity="1" stroke="transparent"
                                                stroke-opacity="1" stroke-linecap="butt" stroke-width="3"
                                                stroke-dasharray="0" class="apexcharts-bar-area" index="0"
                                                clip-path="url(#gridRectMaskcxlo9j0pi)"
                                                pathTo="M 584.5 204.39519900131225L 584.5 29.740327860183726Q 588.25 27.490327860183726 592 29.740327860183726L 592 204.39519900131225L 583 204.39519900131225"
                                                pathFrom="M 584.5 204.39519900131225L 584.5 204.39519900131225L 592 204.39519900131225L 592 204.39519900131225L 583 204.39519900131225"
                                                cy="28.615327860183726" cx="653" j="8" val="86"
                                                barHeight="175.77987114112852" barWidth="10.5"></path>
                                            <path id="SvgjsPath1270"
                                                d="M654.5 204.39519900131225L654.5 15.432663930091877C657 13.932663930091877 659.5 13.932663930091877 662 15.432663930091877L662 204.39519900131225L653 204.39519900131225 "
                                                fill="rgba(50,189,234,1)" fill-opacity="1" stroke="transparent"
                                                stroke-opacity="1" stroke-linecap="butt" stroke-width="3"
                                                stroke-dasharray="0" class="apexcharts-bar-area" index="0"
                                                clip-path="url(#gridRectMaskcxlo9j0pi)"
                                                pathTo="M 654.5 204.39519900131225L 654.5 15.432663930091877Q 658.25 13.182663930091877 662 15.432663930091877L 662 204.39519900131225L 653 204.39519900131225"
                                                pathFrom="M 654.5 204.39519900131225L 654.5 204.39519900131225L 662 204.39519900131225L 662 204.39519900131225L 653 204.39519900131225"
                                                cy="14.307663930091877" cx="723" j="9" val="93"
                                                barHeight="190.08753507122037" barWidth="10.5"></path>
                                            <path id="SvgjsPath1271"
                                                d="M724.5 204.39519900131225L724.5 31.78427985019684C727 30.28427985019684 729.5 30.28427985019684 732 31.78427985019684L732 204.39519900131225L723 204.39519900131225 "
                                                fill="rgba(50,189,234,1)" fill-opacity="1" stroke="transparent"
                                                stroke-opacity="1" stroke-linecap="butt" stroke-width="3"
                                                stroke-dasharray="0" class="apexcharts-bar-area" index="0"
                                                clip-path="url(#gridRectMaskcxlo9j0pi)"
                                                pathTo="M 724.5 204.39519900131225L 724.5 31.78427985019684Q 728.25 29.53427985019684 732 31.78427985019684L 732 204.39519900131225L 723 204.39519900131225"
                                                pathFrom="M 724.5 204.39519900131225L 724.5 204.39519900131225L 732 204.39519900131225L 732 204.39519900131225L 723 204.39519900131225"
                                                cy="30.65927985019684" cx="793" j="10" val="85"
                                                barHeight="173.7359191511154" barWidth="10.5"></path>
                                            <path id="SvgjsPath1272"
                                                d="M794.5 204.39519900131225L794.5 72.6633196504593C797 71.1633196504593 799.5 71.1633196504593 802 72.6633196504593L802 204.39519900131225L793 204.39519900131225 "
                                                fill="rgba(50,189,234,1)" fill-opacity="1" stroke="transparent"
                                                stroke-opacity="1" stroke-linecap="butt" stroke-width="3"
                                                stroke-dasharray="0" class="apexcharts-bar-area" index="0"
                                                clip-path="url(#gridRectMaskcxlo9j0pi)"
                                                pathTo="M 794.5 204.39519900131225L 794.5 72.6633196504593Q 798.25 70.4133196504593 802 72.6633196504593L 802 204.39519900131225L 793 204.39519900131225"
                                                pathFrom="M 794.5 204.39519900131225L 794.5 204.39519900131225L 802 204.39519900131225L 802 204.39519900131225L 793 204.39519900131225"
                                                cy="71.5383196504593" cx="863" j="11" val="65"
                                                barHeight="132.85687935085295" barWidth="10.5"></path>
                                            <g id="SvgjsG1260" class="apexcharts-datalabels"></g>
                                        </g>
                                        <g id="SvgjsG1273" class="apexcharts-series" rel="2"
                                            seriesName="TotalxShare" data:realIndex="1">
                                            <path id="SvgjsPath1275"
                                                d="M35 204.39519900131225L35 50.17984776031494C37.5 48.67984776031494 40 48.67984776031494 42.5 50.17984776031494L42.5 204.39519900131225L33.5 204.39519900131225 "
                                                fill="rgba(255,126,65,1)" fill-opacity="1" stroke="transparent"
                                                stroke-opacity="1" stroke-linecap="butt" stroke-width="3"
                                                stroke-dasharray="0" class="apexcharts-bar-area" index="1"
                                                clip-path="url(#gridRectMaskcxlo9j0pi)"
                                                pathTo="M 35 204.39519900131225L 35 50.17984776031494Q 38.75 47.92984776031494 42.5 50.17984776031494L 42.5 204.39519900131225L 33.5 204.39519900131225"
                                                pathFrom="M 35 204.39519900131225L 35 204.39519900131225L 42.5 204.39519900131225L 42.5 204.39519900131225L 33.5 204.39519900131225"
                                                cy="49.05484776031494" cx="103.5" j="0" val="76"
                                                barHeight="155.3403512409973" barWidth="10.5"></path>
                                            <path id="SvgjsPath1276"
                                                d="M105 204.39519900131225L105 58.35565572036745C107.5 56.85565572036745 110 56.85565572036745 112.5 58.35565572036745L112.5 204.39519900131225L103.5 204.39519900131225 "
                                                fill="rgba(255,126,65,1)" fill-opacity="1" stroke="transparent"
                                                stroke-opacity="1" stroke-linecap="butt" stroke-width="3"
                                                stroke-dasharray="0" class="apexcharts-bar-area" index="1"
                                                clip-path="url(#gridRectMaskcxlo9j0pi)"
                                                pathTo="M 105 204.39519900131225L 105 58.35565572036745Q 108.75 56.10565572036745 112.5 58.35565572036745L 112.5 204.39519900131225L 103.5 204.39519900131225"
                                                pathFrom="M 105 204.39519900131225L 105 204.39519900131225L 112.5 204.39519900131225L 112.5 204.39519900131225L 103.5 204.39519900131225"
                                                cy="57.23065572036745" cx="173.5" j="1" val="72"
                                                barHeight="147.1645432809448" barWidth="10.5"></path>
                                            <path id="SvgjsPath1277"
                                                d="M175 204.39519900131225L175 50.17984776031494C177.5 48.67984776031494 180 48.67984776031494 182.5 50.17984776031494L182.5 204.39519900131225L173.5 204.39519900131225 "
                                                fill="rgba(255,126,65,1)" fill-opacity="1" stroke="transparent"
                                                stroke-opacity="1" stroke-linecap="butt" stroke-width="3"
                                                stroke-dasharray="0" class="apexcharts-bar-area" index="1"
                                                clip-path="url(#gridRectMaskcxlo9j0pi)"
                                                pathTo="M 175 204.39519900131225L 175 50.17984776031494Q 178.75 47.92984776031494 182.5 50.17984776031494L 182.5 204.39519900131225L 173.5 204.39519900131225"
                                                pathFrom="M 175 204.39519900131225L 175 204.39519900131225L 182.5 204.39519900131225L 182.5 204.39519900131225L 173.5 204.39519900131225"
                                                cy="49.05484776031494" cx="243.5" j="2" val="76"
                                                barHeight="155.3403512409973" barWidth="10.5"></path>
                                            <path id="SvgjsPath1278"
                                                d="M245 204.39519900131225L245 31.78427985019684C247.5 30.28427985019684 250 30.28427985019684 252.5 31.78427985019684L252.5 204.39519900131225L243.5 204.39519900131225 "
                                                fill="rgba(255,126,65,1)" fill-opacity="1" stroke="transparent"
                                                stroke-opacity="1" stroke-linecap="butt" stroke-width="3"
                                                stroke-dasharray="0" class="apexcharts-bar-area" index="1"
                                                clip-path="url(#gridRectMaskcxlo9j0pi)"
                                                pathTo="M 245 204.39519900131225L 245 31.78427985019684Q 248.75 29.53427985019684 252.5 31.78427985019684L 252.5 204.39519900131225L 243.5 204.39519900131225"
                                                pathFrom="M 245 204.39519900131225L 245 204.39519900131225L 252.5 204.39519900131225L 252.5 204.39519900131225L 243.5 204.39519900131225"
                                                cy="30.65927985019684" cx="313.5" j="3" val="85"
                                                barHeight="173.7359191511154" barWidth="10.5"></path>
                                            <path id="SvgjsPath1279"
                                                d="M315 204.39519900131225L315 54.2677517403412C317.5 52.7677517403412 320 52.7677517403412 322.5 54.2677517403412L322.5 204.39519900131225L313.5 204.39519900131225 "
                                                fill="rgba(255,126,65,1)" fill-opacity="1" stroke="transparent"
                                                stroke-opacity="1" stroke-linecap="butt" stroke-width="3"
                                                stroke-dasharray="0" class="apexcharts-bar-area" index="1"
                                                clip-path="url(#gridRectMaskcxlo9j0pi)"
                                                pathTo="M 315 204.39519900131225L 315 54.2677517403412Q 318.75 52.0177517403412 322.5 54.2677517403412L 322.5 204.39519900131225L 313.5 204.39519900131225"
                                                pathFrom="M 315 204.39519900131225L 315 204.39519900131225L 322.5 204.39519900131225L 322.5 204.39519900131225L 313.5 204.39519900131225"
                                                cy="53.1427517403412" cx="383.5" j="4" val="74"
                                                barHeight="151.25244726097105" barWidth="10.5"></path>
                                            <path id="SvgjsPath1280"
                                                d="M385 204.39519900131225L385 64.48751169040679C387.5 62.98751169040679 390 62.98751169040679 392.5 64.48751169040679L392.5 204.39519900131225L383.5 204.39519900131225 "
                                                fill="rgba(255,126,65,1)" fill-opacity="1" stroke="transparent"
                                                stroke-opacity="1" stroke-linecap="butt" stroke-width="3"
                                                stroke-dasharray="0" class="apexcharts-bar-area" index="1"
                                                clip-path="url(#gridRectMaskcxlo9j0pi)"
                                                pathTo="M 385 204.39519900131225L 385 64.48751169040679Q 388.75 62.23751169040679 392.5 64.48751169040679L 392.5 204.39519900131225L 383.5 204.39519900131225"
                                                pathFrom="M 385 204.39519900131225L 385 204.39519900131225L 392.5 204.39519900131225L 392.5 204.39519900131225L 383.5 204.39519900131225"
                                                cy="63.36251169040679" cx="453.5" j="5" val="69"
                                                barHeight="141.03268731090546" barWidth="10.5"></path>
                                            <path id="SvgjsPath1281"
                                                d="M455 204.39519900131225L455 42.00403980026246C457.5 40.50403980026246 460 40.50403980026246 462.5 42.00403980026246L462.5 204.39519900131225L453.5 204.39519900131225 "
                                                fill="rgba(255,126,65,1)" fill-opacity="1" stroke="transparent"
                                                stroke-opacity="1" stroke-linecap="butt" stroke-width="3"
                                                stroke-dasharray="0" class="apexcharts-bar-area" index="1"
                                                clip-path="url(#gridRectMaskcxlo9j0pi)"
                                                pathTo="M 455 204.39519900131225L 455 42.00403980026246Q 458.75 39.75403980026246 462.5 42.00403980026246L 462.5 204.39519900131225L 453.5 204.39519900131225"
                                                pathFrom="M 455 204.39519900131225L 455 204.39519900131225L 462.5 204.39519900131225L 462.5 204.39519900131225L 453.5 204.39519900131225"
                                                cy="40.87903980026246" cx="523.5" j="6" val="80"
                                                barHeight="163.5161592010498" barWidth="10.5"></path>
                                            <path id="SvgjsPath1282"
                                                d="M525 204.39519900131225L525 66.53146368041993C527.5 65.03146368041993 530 65.03146368041993 532.5 66.53146368041993L532.5 204.39519900131225L523.5 204.39519900131225 "
                                                fill="rgba(255,126,65,1)" fill-opacity="1" stroke="transparent"
                                                stroke-opacity="1" stroke-linecap="butt" stroke-width="3"
                                                stroke-dasharray="0" class="apexcharts-bar-area" index="1"
                                                clip-path="url(#gridRectMaskcxlo9j0pi)"
                                                pathTo="M 525 204.39519900131225L 525 66.53146368041993Q 528.75 64.28146368041993 532.5 66.53146368041993L 532.5 204.39519900131225L 523.5 204.39519900131225"
                                                pathFrom="M 525 204.39519900131225L 525 204.39519900131225L 532.5 204.39519900131225L 532.5 204.39519900131225L 523.5 204.39519900131225"
                                                cy="65.40646368041993" cx="593.5" j="7" val="68"
                                                barHeight="138.98873532089232" barWidth="10.5"></path>
                                            <path id="SvgjsPath1283"
                                                d="M595 204.39519900131225L595 46.091943780288716C597.5 44.591943780288716 600 44.591943780288716 602.5 46.091943780288716L602.5 204.39519900131225L593.5 204.39519900131225 "
                                                fill="rgba(255,126,65,1)" fill-opacity="1" stroke="transparent"
                                                stroke-opacity="1" stroke-linecap="butt" stroke-width="3"
                                                stroke-dasharray="0" class="apexcharts-bar-area" index="1"
                                                clip-path="url(#gridRectMaskcxlo9j0pi)"
                                                pathTo="M 595 204.39519900131225L 595 46.091943780288716Q 598.75 43.841943780288716 602.5 46.091943780288716L 602.5 204.39519900131225L 593.5 204.39519900131225"
                                                pathFrom="M 595 204.39519900131225L 595 204.39519900131225L 602.5 204.39519900131225L 602.5 204.39519900131225L 593.5 204.39519900131225"
                                                cy="44.966943780288716" cx="663.5" j="8" val="78"
                                                barHeight="159.42825522102353" barWidth="10.5"></path>
                                            <path id="SvgjsPath1284"
                                                d="M665 204.39519900131225L665 31.78427985019684C667.5 30.28427985019684 670 30.28427985019684 672.5 31.78427985019684L672.5 204.39519900131225L663.5 204.39519900131225 "
                                                fill="rgba(255,126,65,1)" fill-opacity="1" stroke="transparent"
                                                stroke-opacity="1" stroke-linecap="butt" stroke-width="3"
                                                stroke-dasharray="0" class="apexcharts-bar-area" index="1"
                                                clip-path="url(#gridRectMaskcxlo9j0pi)"
                                                pathTo="M 665 204.39519900131225L 665 31.78427985019684Q 668.75 29.53427985019684 672.5 31.78427985019684L 672.5 204.39519900131225L 663.5 204.39519900131225"
                                                pathFrom="M 665 204.39519900131225L 665 204.39519900131225L 672.5 204.39519900131225L 672.5 204.39519900131225L 663.5 204.39519900131225"
                                                cy="30.65927985019684" cx="733.5" j="9" val="85"
                                                barHeight="173.7359191511154" barWidth="10.5"></path>
                                            <path id="SvgjsPath1285"
                                                d="M735 204.39519900131225L735 48.13589577030183C737.5 46.63589577030183 740 46.63589577030183 742.5 48.13589577030183L742.5 204.39519900131225L733.5 204.39519900131225 "
                                                fill="rgba(255,126,65,1)" fill-opacity="1" stroke="transparent"
                                                stroke-opacity="1" stroke-linecap="butt" stroke-width="3"
                                                stroke-dasharray="0" class="apexcharts-bar-area" index="1"
                                                clip-path="url(#gridRectMaskcxlo9j0pi)"
                                                pathTo="M 735 204.39519900131225L 735 48.13589577030183Q 738.75 45.88589577030183 742.5 48.13589577030183L 742.5 204.39519900131225L 733.5 204.39519900131225"
                                                pathFrom="M 735 204.39519900131225L 735 204.39519900131225L 742.5 204.39519900131225L 742.5 204.39519900131225L 733.5 204.39519900131225"
                                                cy="47.01089577030183" cx="803.5" j="10" val="77"
                                                barHeight="157.38430323101042" barWidth="10.5"></path>
                                            <path id="SvgjsPath1286"
                                                d="M805 204.39519900131225L805 93.10283955059052C807.5 91.60283955059052 810 91.60283955059052 812.5 93.10283955059052L812.5 204.39519900131225L803.5 204.39519900131225 "
                                                fill="rgba(255,126,65,1)" fill-opacity="1" stroke="transparent"
                                                stroke-opacity="1" stroke-linecap="butt" stroke-width="3"
                                                stroke-dasharray="0" class="apexcharts-bar-area" index="1"
                                                clip-path="url(#gridRectMaskcxlo9j0pi)"
                                                pathTo="M 805 204.39519900131225L 805 93.10283955059052Q 808.75 90.85283955059052 812.5 93.10283955059052L 812.5 204.39519900131225L 803.5 204.39519900131225"
                                                pathFrom="M 805 204.39519900131225L 805 204.39519900131225L 812.5 204.39519900131225L 812.5 204.39519900131225L 803.5 204.39519900131225"
                                                cy="91.97783955059052" cx="873.5" j="11" val="55"
                                                barHeight="112.41735945072173" barWidth="10.5"></path>
                                            <g id="SvgjsG1274" class="apexcharts-datalabels"></g>
                                        </g>
                                    </g>
                                    <line id="SvgjsLine1344" x1="0" y1="0" x2="840"
                                        y2="0" stroke="#b6b6b6" stroke-dasharray="0" stroke-width="1"
                                        class="apexcharts-ycrosshairs"></line>
                                    <line id="SvgjsLine1345" x1="0" y1="0" x2="840"
                                        y2="0" stroke-dasharray="0" stroke-width="0"
                                        class="apexcharts-ycrosshairs-hidden"></line>
                                    <g id="SvgjsG1346" class="apexcharts-yaxis-annotations"></g>
                                    <g id="SvgjsG1347" class="apexcharts-xaxis-annotations"></g>
                                    <g id="SvgjsG1348" class="apexcharts-point-annotations"></g>
                                </g>
                                <g id="SvgjsG1314" class="apexcharts-yaxis" rel="0"
                                    transform="translate(-1, 0)">
                                    <g id="SvgjsG1315" class="apexcharts-yaxis-texts-g"><text id="SvgjsText1316"
                                            font-family="Helvetica, Arial, sans-serif" x="20" y="41.5" text-anchor="end"
                                            dominant-baseline="auto" font-size="11px" font-weight="regular"
                                            fill="#373d3f" class="apexcharts-yaxis-label "
                                            style="font-family: Helvetica, Arial, sans-serif;">100</text><text
                                            id="SvgjsText1317" font-family="Helvetica, Arial, sans-serif" x="20"
                                            y="82.47903980026246" text-anchor="end" dominant-baseline="auto"
                                            font-size="11px" font-weight="regular" fill="#373d3f"
                                            class="apexcharts-yaxis-label "
                                            style="font-family: Helvetica, Arial, sans-serif;">80</text><text
                                            id="SvgjsText1318" font-family="Helvetica, Arial, sans-serif" x="20"
                                            y="123.45807960052491" text-anchor="end" dominant-baseline="auto"
                                            font-size="11px" font-weight="regular" fill="#373d3f"
                                            class="apexcharts-yaxis-label "
                                            style="font-family: Helvetica, Arial, sans-serif;">60</text><text
                                            id="SvgjsText1319" font-family="Helvetica, Arial, sans-serif" x="20"
                                            y="164.43711940078737" text-anchor="end" dominant-baseline="auto"
                                            font-size="11px" font-weight="regular" fill="#373d3f"
                                            class="apexcharts-yaxis-label "
                                            style="font-family: Helvetica, Arial, sans-serif;">40</text><text
                                            id="SvgjsText1320" font-family="Helvetica, Arial, sans-serif" x="20"
                                            y="205.41615920104982" text-anchor="end" dominant-baseline="auto"
                                            font-size="11px" font-weight="regular" fill="#373d3f"
                                            class="apexcharts-yaxis-label "
                                            style="font-family: Helvetica, Arial, sans-serif;">20</text><text
                                            id="SvgjsText1321" font-family="Helvetica, Arial, sans-serif" x="20"
                                            y="246.39519900131228" text-anchor="end" dominant-baseline="auto"
                                            font-size="11px" font-weight="regular" fill="#373d3f"
                                            class="apexcharts-yaxis-label "
                                            style="font-family: Helvetica, Arial, sans-serif;">0</text></g>
                                </g>
                            </svg>
                            <div class="apexcharts-tooltip light">
                                <div class="apexcharts-tooltip-title"
                                    style="font-family: Helvetica, Arial, sans-serif; font-size: 12px;"></div>
                                <div class="apexcharts-tooltip-series-group"><span class="apexcharts-tooltip-marker"
                                        style="background-color: rgb(50, 189, 234);"></span>
                                    <div class="apexcharts-tooltip-text"
                                        style="font-family: Helvetica, Arial, sans-serif; font-size: 12px;">
                                        <div class="apexcharts-tooltip-y-group"><span
                                                class="apexcharts-tooltip-text-label"></span><span
                                                class="apexcharts-tooltip-text-value"></span></div>
                                        <div class="apexcharts-tooltip-z-group"><span
                                                class="apexcharts-tooltip-text-z-label"></span><span
                                                class="apexcharts-tooltip-text-z-value"></span></div>
                                    </div>
                                </div>
                                <div class="apexcharts-tooltip-series-group"><span class="apexcharts-tooltip-marker"
                                        style="background-color: rgb(255, 126, 65);"></span>
                                    <div class="apexcharts-tooltip-text"
                                        style="font-family: Helvetica, Arial, sans-serif; font-size: 12px;">
                                        <div class="apexcharts-tooltip-y-group"><span
                                                class="apexcharts-tooltip-text-label"></span><span
                                                class="apexcharts-tooltip-text-value"></span></div>
                                        <div class="apexcharts-tooltip-z-group"><span
                                                class="apexcharts-tooltip-text-z-label"></span><span
                                                class="apexcharts-tooltip-text-z-value"></span></div>
                                    </div>
                                </div>
                            </div>
                            <div class="apexcharts-toolbar">
                                <div class="apexcharts-menu-icon" title="Menu"><svg
                                        xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24">
                                        <path fill="none" d="M0 0h24v24H0V0z"></path>
                                        <path d="M3 18h18v-2H3v2zm0-5h18v-2H3v2zm0-7v2h18V6H3z"></path>
                                    </svg></div>
                                <div class="apexcharts-menu">
                                    <div class="apexcharts-menu-item exportSVG" title="Download SVG">Download SVG</div>
                                    <div class="apexcharts-menu-item exportPNG" title="Download PNG">Download PNG</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="resize-triggers">
                        <div class="expand-trigger">
                            <div style="width: 923px; height: 336px;"></div>
                        </div>
                        <div class="contract-trigger"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
