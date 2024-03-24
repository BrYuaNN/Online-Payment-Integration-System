var map;
var infoWindow;
var infowindow;
var request;
var pos;
var stores = []//用來存商家的資訊
var markers = [];//用來存marker的陣列
var marker;
var searchmarkers = [];
var infoObj = [];
var geocoder;
var response;
var responseDiv;
// var paymentDict = { 1: "Apple Pay", 2: "Google Pay", 3: "Samsung Pay", 4: "LINE Pay", 5: "街口支付", 6: "台灣pay", 7: "Pi行動錢包", 8: "悠遊付", 9: "歐付寶", 10: "橘子支付", 11: "OPEN錢包", 12: "icash Pay" };
var paymentDict = ["Apple Pay", "Google Pay", "Samsung Pay", "LINE Pay", "街口支付", "台灣pay", "Pi行動錢包", "悠遊付", "歐付寶", "橘子支付", "OPEN錢包", "icash Pay"];
// var storeDict = { 1: "便利商店", 2: "停車場", 3: "咖啡廳", 4: "市場", 5: "藥局", 6: "診所", 7: "超市", 8: "醫院", 9: "飲料店", 10: "餐廳", 11: "其他" };
var storeDict = ["便利商店", "停車場", "咖啡廳", "市場", "藥局", "診所", "超市", "醫院", "飲料店", "餐廳", "其他"];
var filteredPayment = [];//地圖中有顯示的payment種類
var filteredStore = [];////地圖中有顯示的store種類
var scale = 2;

document.getElementById("pay1").onclick = function () { filterPayment(1); };
document.getElementById("pay2").onclick = function () { filterPayment(2); };
document.getElementById("pay3").onclick = function () { filterPayment(3); };
document.getElementById("pay4").onclick = function () { filterPayment(4); };
document.getElementById("pay5").onclick = function () { filterPayment(5); };
document.getElementById("pay6").onclick = function () { filterPayment(6); };
document.getElementById("pay7").onclick = function () { filterPayment(7); };
document.getElementById("pay8").onclick = function () { filterPayment(8); };
document.getElementById("pay9").onclick = function () { filterPayment(9); };
document.getElementById("pay10").onclick = function () { filterPayment(10); };
document.getElementById("pay11").onclick = function () { filterPayment(11); };
document.getElementById("pay12").onclick = function () { filterPayment(12); };

document.getElementById("uLocate1").onclick = function () { setCurrentLoc(); };
document.getElementById("uLocate2").onclick = function () { setCurrentLoc(); };

document.getElementById("store1").onclick = function () { FilterStoreType(1) };
document.getElementById("store2").onclick = function () { FilterStoreType(2) };
document.getElementById("store3").onclick = function () { FilterStoreType(3) };
document.getElementById("store4").onclick = function () { FilterStoreType(4) };
document.getElementById("store5").onclick = function () { FilterStoreType(5) };
document.getElementById("store6").onclick = function () { FilterStoreType(6) };
document.getElementById("store7").onclick = function () { FilterStoreType(7) };
document.getElementById("store8").onclick = function () { FilterStoreType(8) };
document.getElementById("store9").onclick = function () { FilterStoreType(9) };
document.getElementById("store10").onclick = function () { FilterStoreType(10) };
document.getElementById("store11").onclick = function () { FilterStoreType(11) };
document.getElementById("store12").onclick = function () { FilterStoreType(0) };


function createMap() {//建map、放user
  if (navigator.geolocation) {// Browser do support Geolocation
    navigator.geolocation.getCurrentPosition(function (position) {
      pos = {
        lat: position.coords.latitude,//緯度
        lng: position.coords.longitude//經度
      };
    }, function () {
      // handleLocationError(true, infoWindow, map.getCenter());
      handleLocationError(true);
    });
  }
  else {
    // Browser doesn't support Geolocation
    handleLocationError(false);
  }
  //new
  map = new google.maps.Map(document.getElementById('map'), {
    center: pos,
    styles: [
      {
        featureType: 'poi.business',
        stylers: [{ visibility: 'off' }]
      },
      {
        featureType: 'poi.medical',
        stylers: [{ visibility: 'off' }]
      },
      {
        featureType: 'poi.place_of_worship',
        stylers: [{ visibility: 'off' }]
      },
      {
        featureType: 'poi.sports_complex',
        stylers: [{ visibility: 'off' }]
      },
      {
        elementType: "geometry",
        stylers: [{ "color": "#ebe3cd" }]
      },
      {
        elementType: "labels.text.fill",
        stylers: [{ "color": "#523735" }]
      },
      {
        elementType: "labels.text.stroke",
        stylers: [{ "color": "#f5f1e6" }]
      },
      {
        featureType: "administrative",
        elementType: "geometry.stroke",
        stylers: [{ "color": "#c9b2a6" }]
      },
      {
        featureType: "administrative.land_parcel",
        elementType: "geometry.stroke",
        stylers: [{ "color": "#dcd2be" }]
      },
      {
        featureType: "administrative.land_parcel",
        elementType: "labels.text.fill",
        stylers: [{ "color": "#ae9e90" }]
      },
      {
        featureType: "landscape.natural",
        elementType: "geometry",
        stylers: [{ "color": "#dfd2ae" }]
      },
      {
        featureType: "poi",
        elementType: "geometry",
        stylers: [{ "color": "#dfd2ae" }]
      },
      {
        featureType: "poi",
        elementType: "labels.text.fill",
        stylers: [{ "color": "#93817c" }]
      },
      {
        featureType: "poi.park",
        elementType: "geometry.fill",
        stylers: [{ "color": "#a5b076" }]
      },
      {
        featureType: "poi.park",
        elementType: "labels.text.fill",
        stylers: [{ "color": "#447530" }]
      },
      {
        featureType: "road",
        elementType: "geometry",
        stylers: [{ "color": "#f5f1e6" }]
      },
      {
        featureType: "road.arterial",
        elementType: "geometry",
        stylers: [{ "color": "#fdfcf8" }]
      },
      {
        featureType: "road.highway",
        elementType: "geometry",
        stylers: [{ "color": "#f8c967" }]
      },
      {
        featureType: "road.highway",
        elementType: "geometry.stroke",
        stylers: [{ "color": "#e9bc62" }]
      },
      {
        featureType: "road.highway.controlled_access",
        elementType: "geometry",
        stylers: [{ "color": "#e98d58" }]
      },
      {
        featureType: "road.highway.controlled_access",
        elementType: "geometry.stroke",
        stylers: [{ "color": "#db8555" }]
      },
      {
        featureType: "road.local",
        elementType: "labels.text.fill",
        stylers: [{ "color": "#806b63" }]
      },
      {
        featureType: "transit.line",
        elementType: "geometry",
        stylers: [{ "color": "#dfd2ae" }]
      },
      {
        featureType: "transit.line",
        elementType: "labels.text.fill",
        stylers: [{ "color": "#8f7d77" }]
      },
      {
        featureType: "transit.line",
        elementType: "labels.text.stroke",
        stylers: [{ "color": "#ebe3cd" }]
      },
      {
        featureType: "transit.station",
        elementType: "geometry",
        stylers: [{ "color": "#dfd2ae" }]
      },
      {
        featureType: "water",
        elementType: "geometry.fill",
        stylers: [{ "color": "#b9d3c2" }]
      },
      {
        featureType: "water",
        elementType: "labels.text.fill",
        stylers: [{ "color": "#92998d" }]
      }],
    zoom: 15,
    mapTypeControl: false,//地圖種類
    fullscreenControl: false,//全螢幕
    streetViewControl: false,//小人
  });
  setCurrentLoc();//放User Marker
  //TEST
  const input = document.getElementById("pac-input");
  const searchBox = new google.maps.places.SearchBox(input);
  // Bias the SearchBox results towards current map's viewport.
  map.addListener("bounds_changed", () => {
    searchBox.setBounds(map.getBounds());
  });
  let markers = [];
  // Listen for the event fired when the user selects a prediction and retrieve
  // more details for that place.
  searchBox.addListener("places_changed", () => {
    const places = searchBox.getPlaces();
    // console.log(places);
    if (places.length == 0) {
      return;
    }
    console.log("DELETED");
    deleteMarkers(markers);

    markers = [];

    const bounds = new google.maps.LatLngBounds();
    // For each place, get the icon, name and location.
    // console.log(bounds);
    console.log("DELETED");
    deleteMarkers(searchmarkers);
    places.forEach((place) => {
      if (!place.geometry || !place.geometry.location) {
        console.log("Returned place contains no geometry");
        return;
      }
      pos = {
        lat: place.geometry.location.lat(),
        lng: place.geometry.location.lng()
      };
      console.log("TEST");
      console.log(place);
      
      //Search infoWindow content判斷
      var url='';
      var rate='';
      var phone='';
      var price=';'
      var open='';

      if(place.website===undefined){
        url = '';
      }else{
        url ='<li>網站：<a href="' + place.website + '" target="_blank">' + place.website + '</a></li>';
      }
      if(place.rating===undefined){
        rate = '';
      }else{
        rate ='<li>評價： <i class="fas fa-star"></i> × ' + place.rating + '</li>';
      }
      if(place.formatted_phone_number===undefined){
        phone = '';
      }else{
        phone ='<li>電話：' + place.formatted_phone_number + '</li>';
      }
      if(place.price_level===undefined){
        price = '';
      }else{
        var money='';
        for(var i=0; i<place.price_level; i++){
          money=money+'<i class="fas fa-dollar-sign"></i>';
        }
        price ='<li>價位：' + money + '</li>';
      }
      if(place.opening_hours==null){
        open='';
      }else{
        if(place.opening_hours.weekday_text===undefined){
          open = '';
          console.log('123');
        }else{
          var openObj = place.opening_hours;
          var data = openObj.weekday_text;
          let final = data.join('</br>');
          open ='<li>營業時間：</br>' + final + '</li>';
        }
      }

      var content = '<div class="infoWindow"><h1>' + place.name + '</h1><ul><li>地址：' + place.formatted_address + '</li>' + url + rate + phone + price + open + '</div>';
      
        // Create a marker for each place.
        searchMarker = {
        coords: place.geometry.location,
        title: place.name,
        icon: {
          url: "../img/blue.png",
          scaledSize: new google.maps.Size(40, 40)
        },
        content:  content,
        character: "search"
      };
      addMarker(searchMarker);
      if (place.geometry.viewport) {
        // Only geocodes have viewport.
        bounds.union(place.geometry.viewport);
      } else {
        bounds.extend(place.geometry.location);
      }
    });
    map.fitBounds(bounds);
  });
}

function handleLocationError(browserHasGeolocation) {
  map = new google.maps.Map(document.getElementById('map'), {
    center: {
      lat: 22.733035,//緯度
      lng: 120.287869//經度
    },
    zoom: 15,
    mapTypeControl: false,//地圖種類
    fullscreenControl: false,//全螢幕
    streetViewControl: false,//小人
  });
  // infoWindow.setContent(browserHasGeolocation ?
  // 'Error: The Geolocation service failed.' :
  // 'Error: Your browser doesn\'t support geolocation.');
}

function setCurrentLoc() {//設user所在位址為marker(new version)
  if (navigator.geolocation) {// Browser do support Geolocation
    navigator.geolocation.getCurrentPosition(function (position) {
      pos = {
        lat: position.coords.latitude,//緯度
        lng: position.coords.longitude//經度
      };
      // console.log(pos);
      user = {
        coords: pos,
        icon: "../img/Here.ico",
        content: "<h1>USER</h1>",
        character: "user"
      }
      addMarker(user);
      map.setCenter(pos);
      filteredStore = storeDict;
      searchNearBy(pos, scale, null, null);//周圍2km所有可使用行動支付商家;position, range, storeCategory, payment
    }, function () {
      handleLocationError(true);
    });
  }
  else {
    // Browser doesn't support Geolocation
    handleLocationError(false);
    // handleLocationError(false, infoWindow, map.getCenter());
  }
}

function addMarker(props) {//新增Marker(new version)
  var marker = new google.maps.Marker({
    position: props.coords,
    map: map,
  });
  // Check for customicon
  if (props.icon) {
    // Set icon image
    marker.setIcon(props.icon);
  }
  // Check content
  if (props.content) {
    var infoWindow = new google.maps.InfoWindow({
      content: props.content
    });
    marker.addListener('click', function () {
      infoWindow.open(map, marker);
    });
  }
  if (props.character == "search") {
    searchmarkers.push(marker);
  }
  else if (props.character != "user") {
    stores.push(props);
    console.log("stores size: " + stores.length);
    markers.push(marker);
    console.log("markers size: " + markers.length);
    if (!filteredPayment.includes(props.payment)) {
      filteredPayment.push(props.payment);
    }
    if (!filteredStore.includes(props.category)) {
      filteredStore.push(props.category);
    }
  }

  console.log("current payment category num: " + filteredPayment.length);
  for (var i = 0; i < filteredPayment.length; i++) {
    console.log("current payment category : " + filteredPayment[i]);
  }
  console.log("current store category num: " + filteredStore.length);
  for (var i = 0; i < filteredStore.length; i++) {
    console.log("current store category : " + filteredStore[i]);
  }
}

// function searchRange(range) {//搜尋range內所有可使用行動支付商店
//   deleteMarkers(markers);
//   searchNearBy(pos, range, null, null);
// }

function filterPayment(payment) {
  var paymentName = paymentDict[payment - 1];
  console.log("Payment: " + paymentName);

  if (filteredPayment.includes(paymentName)) {//目前地圖中顯示的商店已有此種payment種類
    var index = filteredPayment.indexOf(paymentName);
    filteredPayment.splice(index, 1);//remove paymentname from paymentName 
    deleteMarkers(markers, paymentName, null);//將點選的payment種類從Array及地圖中刪除
  }
  else {//目前地圖中顯示的商店尚未有此種payment種類
    console.log("TEST");
    for (var i = 0; i < filteredStore.length; i++) {
      searchNearBy(pos, scale, storeDict.indexOf(filteredStore[i])+1, payment);//search range in 2KM with payment
    }
    if (!filteredPayment.includes(paymentName)) {
      filteredPayment.push(paymentName);
    }
  }

  console.log("current payment category num: " + filteredPayment.length);
  for (var i = 0; i < filteredPayment.length; i++) {
    console.log("current payment category : " + filteredPayment[i]);
  }
  console.log("current store category num: " + filteredStore.length);
  for (var i = 0; i < filteredStore.length; i++) {
    console.log("current store category : " + filteredStore[i]);
  }
}

function FilterStoreType(storeType) {
  if (storeType == 0) {//全選
    // for(var i=0;i<storeDict.length;i++){
    //   filteredStore=[];
    //   filteredStore.push(storeDict[i]);
    // }
    filteredStore = storeDict;

    for (var i = 0; i < filteredPayment.length; i++) {
      searchNearBy(pos, scale, null, paymentDict.indexOf(filteredPayment[i]) + 1);
    }
  }
  else {//指定商店種類
    var storeTypeName = storeDict[storeType - 1];
    console.log("Store: " + storeTypeName);
    if (filteredStore.includes(storeTypeName)) {//目前地圖中有顯示此種商店種類
      for (var i = 0; i < stores.length; i++) {//遍歷有在地圖上呈現的商家
        // console.log("test2");
        if (stores[i].category != storeTypeName) {//商家所使用的payment不等於storeTypeName
          console.log(stores[i].category);
          for (var j = 0; j < markers.length; j++) {//遍歷在地圖商呈現的markers
            if (stores[i].coords.lat == markers[j].getPosition().lat() && stores[i].coords.lng == markers[j].getPosition().lng()) {//商家的地址等於marker的地址
              markers[j].setMap(null);
              markers.splice(j, 1);
              console.log("markers size: " + markers.length);
              j--;
            }
          }
          stores.splice(i, 1);
          i--;
        }
      }
      filteredStore = [];
      filteredStore.push(storeTypeName);
    }
    else {//目前地圖中未顯示此種商店種類
      filteredStore = [];
      deleteMarkers(markers, null, null);
      for (var i = 0; i < filteredPayment.length; i++) {
        searchNearBy(pos, scale, storeType, paymentDict.indexOf(filteredPayment[i])+1);//search range in 2KM with store
      }
      filteredStore.push(storeTypeName);
    }
  }

  console.log("current payment category num: " + filteredPayment.length);
  for (var i = 0; i < filteredPayment.length; i++) {
    console.log("current payment category : " + filteredPayment[i]);
  }
  console.log("current store category num: " + filteredStore.length);
  for (var i = 0; i < filteredStore.length; i++) {
    console.log("current store category : " + filteredStore[i]);
  }
}

function getValue() {
  // console.log("TEST");
  deleteMarkers(markers, null, null);
  var range = document.getElementById('range');
  var output = document.getElementById("labarValue");//ET
  // console.log(range.value);
  scale = range.value;
  output.innerHTML = scale;//ET
  // console.log(scale);

  if (filteredPayment != null) {
    if (filteredStore.length == 11) {//店家類型全選
      console.log("TEST");
      for (var i = 0; i < filteredPayment.length; i++) {
        console.log(filteredPayment[i]);
        searchNearBy(pos, scale, null, paymentDict.indexOf(filteredPayment[i]) + 1);
      }
    }
    else {//店家類型單選
      console.log("TEST");
      for (var i = 0; i < filteredPayment.length; i++) {
        searchNearBy(pos, scale, storeDict.indexOf(filteredStore[0]) + 1, paymentDict.indexOf(filteredPayment[i]) + 1);//position, range, storeCategory, payment
      }
    }
    // for(var i=0;i<filteredPayment.length;i++){  
    // searchNearBy(pos,scale,TempStoreType,0);
    // }
    range.oninput = function () {//ET
      output.innerHTML = this.value;//ET
    }//ET
  }
  return scale;
}

function searchNearBy(position, range, storeCategory, payment) {//payment可使用此行動支付商家,null:不指定;storeCategory顯示的商家種類
  console.log(position);
  // console.log(payment);
  // console.log(position + " " + range + " " + storeCategory + " " + payment);
  var ajax = new XMLHttpRequest();
  ajax.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      var nearByStore = JSON.parse(this.responseText);
      console.log("Result:" + nearByStore.length);
      for (var i = 0; i < nearByStore.length; i++) {//各家商家資料
        // name,storecategory_category,address,address_Longtitude,address_Latitude,payment_template,payment_PID
        console.log(nearByStore[i][0] + " " + nearByStore[i][1] + " " + nearByStore[i][2] + " " + nearByStore[i][3] + " " + nearByStore[i][4] + " " + nearByStore[i][5] + " " + nearByStore[i][6]);

        var content = '<div class="infoWindow"><h1>' + nearByStore[i][0] + '<span>' + nearByStore[i][1] + "</span></h1><ul><li>" + nearByStore[i][2] + "</li><li>" + nearByStore[i][5] + '</li></ul></div>';

        var store = {
          coords: {
            lat: parseFloat(nearByStore[i][4]),//緯度
            lng: parseFloat(nearByStore[i][3])//經度
            // lat: x,//緯度
            // lng: y//經度
          },
          // icon:"../img/Here.ico",
          icon: { url: "../img/green.png", scaledSize: new google.maps.Size(40, 40) },
          content: content,//店名、類型、地址、行動支付
          category: nearByStore[i][1],
          payment: nearByStore[i][5]
        };
        addMarker(store);
        // highlightPaymentButton(nearByStore[i][6]);//將目前有顯示的payment的marker反白
      }
    }

  };
  ajax.open("GET", "queryNearByStoreDB.php?lng=" + position.lng + "&" + "lat=" + position.lat + "&" + "range=" + range + "&" + "storeCategory=" + storeCategory + "&" + "payment=" + payment, true);
  // ajax.open("GET", "queryNearByStoreDB.php?lng=" + position.lng + "&" + "lat=" + position.lat + "&" + "range=" + range + "&" + "userpayment=" + userPayment, true);
  //search?q=網址一次傳多個值&addon=opensearch
  ajax.send();
}

function geocode(request) {
  // clear();
  geocoder
    .geocode(request)
    .then((result) => {
      const { results } = result;

      map.setCenter(results[0].geometry.location);
      for (var i = 0; i < results.length; i++) {
        marker.setPosition(results[i].geometry.location);
      }

      marker.setMap(map);
      responseDiv.style.display = "block";
      response.innerText = JSON.stringify(result, null, 2);
      return results;
    })
    .catch((e) => {
      alert("Geocode was not successful for the following reason: " + e);
    });
}

// function clear() {
//   marker.setMap(null);
//   responseDiv.style.display = "none";
// }

// function createInfo(marker) {
//   return function () {
//     infowindow.open(map, marker);
//   };
// }

function closeOtherInfo() {
  if (InforObj.length > 0) {
    InforObj[0].set("marker", null);
    InforObj[0].close();
    InforObj.length = 0;
  }
}

function deleteMarkers(selectedmarkers, deletedPayment, deletedStoreCategory) {//刪除傳入之markers(array)
  console.log("TEST");
  if (deletedPayment == null && deletedStoreCategory == null) {//不指定要刪除之payment類型及store類型
    for (var i = 0; i < selectedmarkers.length; i++) {//將地圖中所有marker清除
      selectedmarkers[i].setMap(null);
      selectedmarkers.splice(i, 1);//remove paymentname from paymentName
      stores.splice(i, 1);
      i--;
    }
    // filteredPayment = [];
    // filteredStore = [];
    console.log(markers.length);
  }

  else {//deletedPayment!=nul || deletedStoreCategory!=null
    if (deletedPayment) {//指定要刪除payment類型
      // console.log("test1");
      for (var i = 0; i < stores.length; i++) {//遍歷有在地圖上呈現的商家
        if (stores[i].payment == deletedPayment) {//商家所使用的payment等於deletedPayment
          console.log(stores[i].payment);
          for (var j = 0; j < selectedmarkers.length; j++) {//遍歷在地圖商呈現的markers
            if (stores[i].coords.lat == selectedmarkers[j].getPosition().lat() && stores[i].coords.lng == selectedmarkers[j].getPosition().lng()) {//商家的地址等於marker的地址
              selectedmarkers[j].setMap(null);
              selectedmarkers.splice(j, 1);//自selectedmarkers中移除
              j--;
            }
          }
          stores.splice(i, 1);//自stores移除
          i--;
        }
      }
    }
    if (deletedStoreCategory) {//指定要刪除store類型
      console.log("test2");
      // console.log(selectedmarkers.length);
      for (var i = 0; i < stores.length; i++) {//遍歷有在地圖上呈現的商家
        // console.log("test2");
        if (stores[i].category == deletedStoreCategory) {//商家所使用的payment等於deletedPayment
          console.log(stores[i].category);
          for (var j = 0; j < selectedmarkers.length; j++) {//遍歷在地圖商呈現的markers
            // console.log("test3");
            if (stores[i].coords.lat == selectedmarkers[j].getPosition().lat() && stores[i].coords.lng == selectedmarkers[j].getPosition().lng()) {//商家的地址等於marker的地址
              // console.log("test4");
              selectedmarkers[j].setMap(null);
              selectedmarkers.splice(j, 1);
              console.log("markers size: " + markers.length);
              j--;
            }
          }
          stores.splice(i, 1);
          console.log("stores size: " + stores.length);
          i--;
        }
      }
    }
  }
}

function setplaceinfo(place) {
  var test = place.name;
  google.maps.event.addListener(marker, 'click', (function (marker, infowindow) {
    return function () {
      infowindow.open(map, marker);
    };
  })(marker, infowindow));
}