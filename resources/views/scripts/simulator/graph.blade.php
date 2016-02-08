@extends('layouts.master')
@section('content')
    <!-- LLicencja  dev chartów-->
<script type="text/javascript">
    var ZoomChartsLicense = "ZCS-12u20zlca: Free ZoomCharts development licence for nos..@..l.com (valid for development and QA only)";
    var ZoomChartsLicenseKey = "56a0f53f01379d84687fafc43da3898c2f9503147afae64248"+
            "857f05e66ef596099e811405a3e5f472ba9f2ba2cbd71c72a5f931d5fda622466756d8d07ebc5"+
            "394d119d393814f199bb1f8390bf74317bb6d95048616fa57cba052c444cb665dbef0ba5bb62c"+
            "485d768b7acaed434b112a36d6d370fbbc05214bff40835215c06517479cd47de4b48df31b0b1"+
            "3645eaf0220202e097056ef346a352d74e6acfadcc648363f16d8a5545401896742543f52a484"+
            "e1c0fd689bc2f41c3ea6107cc07dee2b196af2f37cb012423cac141f701db395f3289dfb34b1d"+
            "63eed9c67ed3f4a70e12e0de4618ed5e59d8f5c8642ade374a67ed2ebc3e0d4c62f7fcc97c97e";
</script>
    <!-- -->
    <script src="https://cdn.zoomcharts-cloud.com/1/stable/zoomcharts.js"></script>

    <div id="demo" style="height: 100%; margin: 0px; padding: 0px;">
    </div>
    <script>
        var t = new NetChart({
            container: document.getElementById("demo"),
            area: { height: 800 },
            data: { url: "/data.json" },
            nodeMenu: {enabled: false},
            linkMenu: {enabled: false},
            style: {
                nodeAutoScaling: "linear",
                nodeDetailMinSize: 0,
                linkStyleFunction: linkStyle,
                nodeLabel: {
                    textStyle: { font: "28px Roboto" }
                }
            },
            layout: {
                nodeSpacing: 20
            },
            navigation: {
                mode: "showall"
            },
            interaction: {
                resizing: {enabled: false}
            },
            theme: NetChart.themes.dark
        });
        function linkStyle(link){
            if (link.data.color != null && link.data.color != ''){
                link.fillColor = link.data.color;
                link.radius = 2;
            } else{
                link.fillColor = "lightgray";
                link.radius = 1;
            }
            if (link.data.bitrate != null && link.data.bitrate != ''){
                link.label = link.data.bitrate;
            }
        }
    </script>

@stop