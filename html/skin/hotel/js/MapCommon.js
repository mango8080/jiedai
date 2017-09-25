


var mapCommon = {};
mapCommon.isForegin = false;

var hotelCMap = null;


function getHotelMapForList(hotels) {

    if (hotels && hotels.length > 0) {
        for (var i = 0; i < hotels.length; i++) {
            if (hotels[i].CurrencyType != "¥" && hotels[i].CurrencyType != "RMB") {
                mapCommon.isForegin = true;
                break;
            }
        }
    }

    if (mapCommon.isForegin) {
        hotelCMap = hotelBingMap;
    }
    else {
        hotelCMap = hotelMap;
    }
    return hotelCMap;
}



function getHotelMap(hotel) {

    if (hotel && hotel.CurrencyType && hotel.CurrencyType != "¥" && hotel && hotel.CurrencyType != "RMB") {


        mapCommon.isForegin = true;


    }

    if (mapCommon.isForegin) {
        hotelCMap = hotelBingMap;
    }
    else {
        hotelCMap = hotelMap;
    }
    return hotelCMap;
}


