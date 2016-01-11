@extends('layouts.master')
@section('content')
    <script src="https://cdn.zoomcharts-cloud.com/1/stable/zoomcharts.js"></script>

    <div id="demo">
    </div>
    <script>
        var t = new NetChart({
            container: document.getElementById("demo"),
            area: { height: 350 },
            data: { url: "/data.json" },
            nodeMenu: {enabled: false},
            linkMenu: {enabled: false},
            style: {
                nodeAutoScaling: "linear",
                nodeDetailMinSize: 0
            },
            layout: {
                nodeSpacing: 20
            },
            navigation: {
                mode: "showall"
            },
            interaction: {
                resizing: {enabled: false}
            }
        });
    </script>

@stop