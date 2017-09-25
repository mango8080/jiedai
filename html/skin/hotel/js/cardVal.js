var jje_card_val = (function(){

    var east = function(card){
        if(/^\d{12}$/.test(card)){
            x = card.charAt(0)+'0'+card.substr(2);
            return card.charAt(1) == (x % 7);
        }
        return false;
    };

    var air = function(card){
        if(/^CA\d{12}$/.test(card)){
          x = card.charAt(2)+card.charAt(3)+card.substr(5);
          verifyDigit = x % 7;
          if( verifyDigit == 4){
              verifyDigit = 8;
          }
          return card.charAt(4) == verifyDigit;
        }
        if(/\d{12}$/.test(card)){
            x = card.charAt(0)+card.charAt(1)+card.substr(3);
            verifyDigit = x % 7;
            if( verifyDigit == 4){
                verifyDigit = 8;
            }
            return card.charAt(2) == verifyDigit;
        }
        return false;
    };

    var pearl = function(card){
        if(/^\d{12}$/.test(card)){
            var result = 0;
            var i = card.length;
            while (i-- > 1) {
              result = result + parseInt(card.charAt(i));
            }
            return card.charAt(0) == result % 7;
        }
        return false;
    };

    var wings = function(card){
        if(/^\d{10}$/.test(card)){
            return true;
        }
        return false;
    };

    var asia = function(card){
        if(/^\d{10}$/.test(card)){
            return card.charAt(0)>0;
        }
        return false;
    };

    var avios = function(card){
        return true;
    };

    var jal = function(card){
        return true;
    };

    var mf = function(card){
        return true;
    };

    return {
        asia : asia,
        wings : wings,
        pearl : pearl,
        air : air,
        east : east,
        avios : avios,
        jal : jal,
        mf : mf
    };
})();


