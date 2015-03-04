// collections management
// « add » button
function addButton() {
    var $addItemLink = $('<a href="#" class="add_item_link btn-xs btn-warning">Add</a>');
    return $('<span></span>').append($addItemLink);
};

// adapted from http://symfony.com/doc/2.3/cookbook/form/form_collections.html
function addItemForm(collectionHolder, length) {
    var prototype = collectionHolder.attr('data-prototype');
    //alert('prototype: '+prototype);
    // Replaces '__name__' in the prototype HTML by the index of the current item
    var newItemForm = prototype.replace(/__name__/g, length);
    // Displays the item form in a <div>, just before the "add" button
    var $newItemFormDiv = $('<div></div>').append(newItemForm);
    var coll = collection.find('.modal-body');
    if (coll.length===0) { // normal case
        collectionHolder.append($newItemFormDiv);
    } else { // within a modal popup
        coll.find('.add_item_link:last').before($newItemFormDiv);
    }
    // add a "remove" link at the end of the new form
    addItemFormDeleteLink($newItemFormDiv);
}

function addItemFormDeleteLink($itemFormLi) {
    var $removeFormA = $('<a href="#" class="btn-xs btn-danger">Remove</a>');
    $itemFormLi.append($removeFormA);
    $removeFormA.on('click', function (e) {
        e.preventDefault();
        if (confirm("Are you sure?")) {
            $itemFormLi.remove();
        }
    });
}

// not needed anymore, since we put this in the 'modalcollection' widget
function modalCollection(name, content){
    var id = 'modal_'+name;
    //content.after(addButton());
    var result = '<div class="modal fade" role="dialog" id="'+id+'">\
  <div class="modal-dialog">\
    <div class="modal-content">\
      <div class="modal-header">\
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>\
        <h4 class="modal-title">' + content.prev('label').html() + '</h4>\
      </div>\
      <div class="modal-body">\
      ' + content.html() + addButton().html() + '\
      </div>\
      <div class="modal-footer">\
        <button type="button" data-dismiss="modal" class="btn btn-primary">Close</button>\
      </div>\
    </div><!-- /.modal-content -->\
  </div><!-- /.modal-dialog -->\
</div><!-- /.modal -->';
    content.html(result);
    content.after('<button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#'+id+'">View</button>');
}