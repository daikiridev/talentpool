// collections management
// « add » button
function addButton(name) {
    return $('<a href="#" class="add_item_link btn-xs btn-warning">Add '+name+'</a>');
    //return $('<span></span>').append($addItemLink);
    //return $($addItemLink);
}
;

// adapted from http://symfony.com/doc/2.3/cookbook/form/form_collections.html
function addItemForm(collectionHolder, length) {
    var prototype = collectionHolder.attr('data-prototype');
    console.log('prototype: ' + prototype);
    var $newItemFormDiv;
//////////    
// TODO //
//////////
//when adding a new collection of collections: only the first '__name__' of each field should be replaced
    var embeddedPrototypes = prototype.match(/data-prototype="[^"]*"/g);
    if (embeddedPrototypes) { 
        console.log('embeddedProtypes '+embeddedPrototypes);
        for (var i=0; i<embeddedPrototypes.length; i++) {
            var supprQuote = embeddedPrototypes[i].replace(/&quot;/g, 'π');
            var embeddedCollectionName = supprQuote.match(/π[^π]*__name__[^π]*__name__[^π]*π/);
            var embeddedName = embeddedCollectionName[0].replace(/π[^π]*__name___([^π]*)___name__[^π]*π/g,'$1');
            alert('WARNING: collection ' + collectionHolder.attr('id') + ' includes a collection of '+ embeddedName +
                    '. Please update your ' + collectionHolder.attr('id')+ ' before adding ' + embeddedName );
        }
    }
    // Replaces '__name__' in each field of the prototype by the index of the current item
    $newItemFormDiv = $(prototype.replace(/__name__label__/,length + ' (new)').replace(/__name__/g, length));    
    $newItemFormDiv.find('textarea').each(function(){
        $(this).wysihtml5();
    });
    collectionHolder.append($newItemFormDiv);
    // add a "remove" link at the end of the new form
    addItemFormDeleteLink($newItemFormDiv, collectionHolder.attr('id').replace(/.*_(\w+)e?s/, "$1"));
}

function addItemFormDeleteLink($itemFormLi, name) {
    var $removeFormA = $('<a href="#" class="btn-xs btn-danger">Remove '+name+'</a>');
    $itemFormLi.append($removeFormA);
    $removeFormA.on('click', function (e) {
        e.preventDefault();
        if (confirm("Are you sure?")) {
            $itemFormLi.remove();
        }
    });
}

// not needed anymore, since we put this in the 'modalcollection' widget
function modalCollection(name, content) {
    var id = 'modal_' + name;
    var result = '<div class="modal fade" role="dialog" id="' + id + '">\
  <div class="modal-dialog">\
    <div class="modal-content">\
      <div class="modal-header">\
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>\
        <h4 class="modal-title">' + content.prev('label').html() + '</h4>\
      </div>\
      <div class="modal-body">\
      ' + content.html() + addButton(name).html() + '\
      </div>\
      <div class="modal-footer">\
        <button type="button" data-dismiss="modal" class="btn btn-primary">Close</button>\
      </div>\
    </div><!-- /.modal-content -->\
  </div><!-- /.modal-dialog -->\
</div><!-- /.modal -->';
    content.html(result);
    content.after('<button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#' + id + '">View</button>');
}

// Google places API
var autocomplete = new Array();

// Handle the way form inputs are filled in
// eg addressPrefix: 'talentpool_profiles_0_mobilities_3_'
function convertForm(addressPrefix, field) {
    //console.log("convertForm('"+addressPrefix+"'): "+addressPrefix.replace((/.*_([^_]+)(_\d+_)?[^_]*$/), "$1"));
    switch (addressPrefix.replace((/.*_([^_]+)(_\d+_)?[^_]*$/), "$1")) {
        case 'mobilities':
            return {
                locality: [{field: 'city', action: 'replace', format: 'short_name'}],
                administrative_area_level_1: [{field: 'region', action: 'replace', format: 'short_name'}],
                country: [{field: 'country', action: 'replace', format: 'short_name'}],
                continent: [{field: 'zone', action: 'replace', format: 'short_name'}]
            };
        default: // case 'addresses':
            return {
                street_number: [{field: field, action: 'replace', format: 'short_name'}], // the search input field is replaced by the street number
                route: [{field: field, action: 'add', format: 'long_name'}], // the route is added to the search input field
                locality: [{field: 'city', action: 'replace', format: 'long_name'}],
                postal_code: [{field: 'zip', action: 'replace', format: 'long_name'}],
                administrative_area_level_1: [{field: 'province', action: 'replace', format: 'long_name'}],
                country: [{field: 'country', action: 'replace', format: 'long_name'}]
            };

    }
}

function googleInit(addressPrefix, field) {
    // Create the autocomplete object
    // Types are availabe here: https://developers.google.com/places/documentation/supported_types
    var searchType;
    switch (addressPrefix.replace((/.*_([^_]+)(_\d+_)?[^_]*$/), "$1")) {
        case 'addresses':
            searchType = 'address';
            break;
        case 'mobilities':
            searchType = 'geocode';
            //alert('mobilities');
            break;
        default:
            searchType = 'address';
    }
    console.log('googleInit ' + addressPrefix + field + ' (type: ' + searchType + ')');
    autocomplete[addressPrefix] = new google.maps.places.Autocomplete(
            /** @type {HTMLInputElement} */(document.getElementById(addressPrefix + field)),
            {types: [searchType]});
    // When the user selects an address from the dropdown,
    // populate the address fields in the form.
    google.maps.event.addListener(autocomplete[addressPrefix], 'place_changed', function () {
        fillInAddress(addressPrefix, field);
    });
}

function fillInAddress(addressPrefix, field) {
    // Get the place details from the autocomplete object.
    var place = autocomplete[addressPrefix].getPlace();
    var convForm = convertForm(addressPrefix, field);

    // Reset all inputs
    for (var component in convForm) {
        var id = '#' + addressPrefix + convForm[component][0]['field'];
        $(id).val('');
        $(id).prop('disabled', false);
    }

    // Get each component of the address from the place details
    // and fill the corresponding field on the form.
    for (var i = 0; i < place.address_components.length; i++) {
        var addressType = place.address_components[i].types[0];
        console.log(addressType+': '+place.address_components[i]['long_name']);
        if (convForm[addressType]) {
            var val = place.address_components[i][convForm[addressType][0]['format']]; // short_name or long_name
            var id = '#' + addressPrefix + convForm[addressType][0]['field'];
            console.log('into id: '+id);
            if (convForm[addressType][0]['action'] === 'add') { // append the value to the field
                $(id).val($(id).val() + ' ' + val);
            } else { // put the value into the field
                $(id).val(val);
            }
            $(id).trigger('change'); // since some of the fields are hidden fields (which don't natively throw a change event)
        }
    }
}

// initialize things
$(document).ready(function () {
    // catches a click on an "add" button #}
    $('.add_item_link').on('click', function (e) {
        e.preventDefault();
        var collection = $(this).parent('div').children('.form-collection');
        // if this is the comments collection, start numbering at the end index stored in DB
//        var length = collection.is("#candidate_comments_new") ? commentCollectionDB.children().length :
//                collection.children('.child-count').length > 0 ? collection.children('.child-count').children().length : collection.children().length;
        // computes collection's length
        var length = 0;
        if (collection.is("#candidate_comments_new")) { // we start at the end of the comments stored in DB
            length = commentCollectionDB.children().length + collection.children().length;
        } else  {
            length = collection.children('div').length;
        }
        console.log('"add" clicked for '+collection.attr('id') + ' (length: ' + length + ')');
        //console.log($(this).parent().html());
        addItemForm(collection, length);
        // if this is an address form, initialise google place API
        var id = collection.attr('id');
        if (id.match(/_addresses$/)) {
            googleInit(id + '_' + length + '_', 'street1'); // location google search is done in the 'street1' field
        }
        else if (id.match(/_mobilities$/)) {
            googleInit(id + '_' + +length + '_', 'location'); // location google search is done in the 'location' field
        }
    });

    $('.form-collection').each(function () {
        var collection = $(this);
//        var children = $(this).find('.modal-body').length>0?$(this).find('.modal-body').children('div'):$(this).children('div');
        var children = collection.children('div');
        children.each(function () { // adds a remove button to each item of the collection
            //console.log(collection.attr('id')+'>child content: '+$(this).html());
            addItemFormDeleteLink($(this), collection.attr('id').replace(/.*_(\w+)e?s/, "$1"));
        });
        var id = collection.attr('id');
        if (id.match(/_addresses$/) && children.length >0) {
            console.log('computing google fields for ' + id);
            for (i = 0; i < children.length; i++) {
                googleInit(id + '_' + i + '_', 'street1'); // location search is done in the 'street1' field
            }
        } else if (id.match(/_mobilities$/) && children.length >0) {
            console.log('computing google fields for ' + id);
            for (i = 0; i < children.length; i++) {
                googleInit(id + '_' + i + '_', 'location'); // location search is done in the 'location' field
            }
        }

    });
});