function map_init() {

        DG.autoload(function() { 
            var map = new DG.Map('myMapId'); 
            map.setCenter(new DG.GeoPoint(104.305979,52.279567), 17); 
            map.controls.add(new DG.Controls.Zoom()); 


            var myMarker = new DG.Markers.Common({
                 geoPoint: new DG.GeoPoint(104.306,52.279582)
            });
            map.markers.add(myMarker);
        }); 
}