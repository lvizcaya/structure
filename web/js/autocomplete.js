var placeSearch, autocomplete;
var componentForm = {
    locality: 'long_name',
    country: 'long_name',
};

function initAutocomplete() {
    autocomplete = new google.maps.places.Autocomplete((document.getElementById('autocomplete')), {types: ['geocode']});
    autocomplete.addListener('place_changed', fillInAddress);
}

function fillInAddress() {
    var place = autocomplete.getPlace();
    $('.find-city').val('');
    $('.find-country').val('');
    for (var i = 0; i < place.address_components.length; i++) {
        var addressType = place.address_components[i].types[0];
        if (componentForm[addressType]) {
            var val = place.address_components[i][componentForm[addressType]];
            if (addressType == 'locality') {
                $('.find-city').val(val);
            }
            if (addressType == 'country') {
                $('.find-country').val(val);
            }
        }
    }
}
