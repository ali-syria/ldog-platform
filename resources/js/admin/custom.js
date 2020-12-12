var $ = require( "jquery" );
const backend=window.laravel;
const livewire=window.livewire;

const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 6000,
    timerProgressBar: true,
    onOpen: (toast) => {
        toast.addEventListener('mouseenter', Swal.stopTimer)
        toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
});
var App = {};

App.toast = {
    message: function(message, type,timer){
        if ($.isArray(message)) {
            $.each(message, function(i, item){
                App.toast.message(item, type);
            });
        } else {
            Toast.fire({
                icon: type,
                title: message,
                timer: timer,
            });
        }
    },
    error: function(message){
        App.toast.message(message, 'error',10000);
    },
    success: function(message){
        App.toast.message(message, 'success',3000);
    },
    info: function(message){
        App.toast.message(message, 'info',10000);
    },
    warning: function(message){
        App.toast.message(message, 'warning',10000);
    },
    validationError: function(errors){
        $.each(errors, function(i, fieldErrors){
            App.toast.error(fieldErrors);
        });
    }
};

livewire.on('success',($message)=>App.toast.success($message));
livewire.on('error',($message)=>App.toast.error($message));
livewire.on('info',($message)=>App.toast.info($message));
livewire.on('warning',($message)=>App.toast.warning($message));
/**
 *
 * @param type string 'insertAfter' or 'insertBefore'
 * @param entityName
 * @param id
 * @param positionId
 */
var changePosition = function(requestData){
    $.ajax({
        'url': '/sort',
        'type': 'POST',
        'data': requestData,
        'success': function(data) {
            if (data.success) {
                App.toast.success('Saved successfully!');
            } else {
                App.toast.validationError(data.errors);
            }
        },
        'error': function(){
            App.toast.error('Something went wrong!');
        }
    });
};

$(document).ready(function(){
    var $sortableTable = $('.sortable');
    if ($sortableTable.length > 0) {
        $sortableTable.sortable({
            handle: '.sortable-handle',
            axis: 'y',
            update: function(a, b){

                var entityName = $(this).data('entityname');
                var $sorted = b.item;

                var $previous = $sorted.prev();
                var $next = $sorted.next();

                if ($previous.length > 0) {
                    changePosition({
                        parentId: $sorted.data('parentid'),
                        type: 'moveAfter',
                        entityName: entityName,
                        id: $sorted.data('itemid'),
                        positionEntityId: $previous.data('itemid')
                    });
                } else if ($next.length > 0) {
                    changePosition({
                        parentId: $sorted.data('parentid'),
                        type: 'moveBefore',
                        entityName: entityName,
                        id: $sorted.data('itemid'),
                        positionEntityId: $next.data('itemid')
                    });
                } else {
                    App.toast.error('Something went wrong!');
                }
            },
            cursor: "move"
        });
    }
});

window.LivewireFunctions={
    delete:function (component,id) {
        Swal.fire({
            title: 'Are you sure?',
            text: 'Are you sure you want to delete this item?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes',
            cancelButtonText: 'Cancel',
            width: '32rem',
            padding: '1rem',
        }).then((result) => {
            if (result.value) {
                component.call('delete',id);
            }
        });
    }
}

