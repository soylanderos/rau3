function iniciarMap(){
    var coord = {lat:31.6590561 ,lng: -106.3870784};
    var map = new google.maps.Map(document.getElementById('map'),{
      zoom: 10,
      center: coord
    });
    var marker = new google.maps.Marker({
      position: coord,
      map: map
    });
}