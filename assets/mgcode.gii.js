// model generator: hide class name inputs when table name input contains *
$('#abstractModel-generator #generator-tablename').change(function () {
    var show = ($(this).val().indexOf('*') === -1);
    $('.field-generator-modelclass').toggle(show);
    if ($('#generator-generatequery').is(':checked')) {
        $('.field-generator-queryclass').toggle(show);
    }
}).change();

// model generator: translate table name to model class
$('#abstractModel-generator #generator-tablename').on('blur', function () {
    var tableName = $(this).val();
    var tablePrefix = $(this).attr('table_prefix') || '';
    if (tablePrefix.length) {
        // if starts with prefix
        if (tableName.slice(0, tablePrefix.length) === tablePrefix) {
            // remove prefix
            tableName = tableName.slice(tablePrefix.length);
        }
    }
    if ($('#generator-modelclass').val() === '' && tableName && tableName.indexOf('*') === -1) {
        var modelClass = '';
        $.each(tableName.split('_'), function() {
            if(this.length>0)
                modelClass+=this.substring(0,1).toUpperCase()+this.substring(1);
        });
        $('#generator-modelclass').val(modelClass).blur();
    }
});

// model generator: translate model class to query class
$('#abstractModel-generator #generator-modelclass').on('blur', function () {
    var modelClass = $(this).val();
    if (modelClass !== '') {
        var queryClass = $('#generator-queryclass').val();
        if (queryClass === '') {
            queryClass = modelClass + 'Query';
            $('#generator-queryclass').val(queryClass);
        }
    }
});

// model generator: synchronize query namespace with model namespace
$('#abstractModel-generator #generator-ns').on('blur', function () {
    var stickyValue = $('#abstractModel-generator .field-generator-queryns .sticky-value');
    var input = $('#abstractModel-generator #generator-queryns');
    if (stickyValue.is(':visible') || !input.is(':visible')) {
        var ns = $(this).val();
        stickyValue.html(ns);
        input.val(ns);
    }
});