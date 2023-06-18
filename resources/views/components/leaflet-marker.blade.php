<script>
    L.marker([{{ $point['lat'] }}, {{ $point['long'] }}]).addTo(mymap)
        .bindPopup({!! json_encode($popupContent) !!});
    
</script>
