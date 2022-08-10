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
            console.log(this.latVal);
            let map = new google.maps.Map(document.getElementById("map"), {
                center: { lat: this.latVal, lng: this.lngVal },
                zoom: 12,
            });

            const latlng = {
                lat: parseFloat(this.latVal),
                lng: parseFloat(this.lngVal),
            };
             const geocoder = new google.maps.Geocoder();
            // const infowindow = new google.maps.InfoWindow();
             geocoder.geocode({ location: latlng })
                .then((response) => {
                if (response.results[0]) {
                    map.setZoom(15);

                    const marker = new google.maps.Marker({
                    position: latlng,
                    map: map,
                    });

                    // infowindow.setContent(response.results[0].formatted_address);
                    // infowindow.open(map, marker);
                } else {
                    window.alert("No results found");
                }
                })
                .catch((e) => console.log("Geocoder failed due to: " + e));
        },
    },
    mounted() {
        // this.initMap()
    },
    watch: {
        lat: function(value) {
            console.log(value)
            this.latVal = Number(value)
        },
        lng: function(value) {
            console.log(value)
            this.lngVal = Number(value)

            this.initMap()
        },
    }

}
</script>

<style>

</style>
