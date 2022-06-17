<template>
    <div id="map" class="h-100 mt-2"></div>
</template>

<script>
export default {
    props: ['lat', 'lng'],
    data() {
            return {
                latVal: Number(this.lat),
                lngVal: Number(this.lng),
            }
    },
    methods: {
        initMap() {
            let map = new google.maps.Map(document.getElementById("map"), {
                center: { lat: this.latVal, lng: this.lngVal },
                zoom: 12,
            });

            //  var geocoder = new google.maps.Geocoder();
            // geocoder.geocode({ 'address': "Navale Bridge, Maharashtra," }, function (results, status) {
            //     if (status == google.maps.GeocoderStatus.OK) {
            //         map.setCenter(results[0].geometry.location);
            //         var marker = new google.maps.Marker({
            //             map: map,
            //             position: results[0].geometry.location,
            //         });
            //     } else
            //       alert("Problem with geolocation");

            // });
        },
    },
    mounted() {
        this.initMap()
    },

}
</script>

<style>

</style>
