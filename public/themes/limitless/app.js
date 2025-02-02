let format_uang_options = {
    formatOnPageLoad: true,
    allowDecimalPadding: false,
    decimalCharacter: ",",
    digitGroupSeparator: ".",
    unformatOnSubmit: true,
    showWarnings:false,
    modifyValueOnWheel:false
}

let format_angka_options = {
    allowDecimalPadding: false,
    formatOnPageLoad: true,
    minimumValue:0,
    maximumValue:9999,
    numericPos:true,
    decimalPlaces : 0,
    digitGroupSeparator : '',
    showWarnings:false,
    unformatOnSubmit: true,
    modifyValueOnWheel:false
}

function checkExistsID(id) {
    var status = false;
    if ($(id).length) status = true;
    return status;
}

function formatPaguTotalIndikatifOPD(totalpaguindikatif)
{
    var optionnumeric =  {
                            allowDecimalPadding: false,
                            decimalCharacter: ",",
                            digitGroupSeparator: ".",
                            showWarnings:false
                        };
    
    if (checkExistsID('#datastatus #totalstatusopd0'))
    {
        $('#datastatus #totalstatusopd0').html(totalpaguindikatif[0]);                
        new AutoNumeric ('#datastatus #totalstatusopd0',optionnumeric); 
    }    
    if (checkExistsID('#datastatus #totalstatusopd1'))
    {
        $('#datastatus #totalstatusopd1').html(totalpaguindikatif[1]);                        
        new AutoNumeric ('#datastatus #totalstatusopd1',optionnumeric); 
    }    
    if (checkExistsID('#datastatus #totalstatusopd2'))
    {
        $('#datastatus #totalstatusopd2').html(totalpaguindikatif[2]); 
        new AutoNumeric ('#datastatus #totalstatusopd2',optionnumeric);        
    }
    if (checkExistsID('#datastatus #totalstatusopd12'))
    {
        $('#datastatus #totalstatusopd12').html(parseFloat(totalpaguindikatif[1])+parseFloat(totalpaguindikatif[2]));        
        new AutoNumeric ('#datastatus #totalstatusopd12',optionnumeric);        
    }
    if (checkExistsID('#datastatus #totalstatusopd3'))
    {
        $('#datastatus #totalstatusopd3').html(totalpaguindikatif[3]);        
        new AutoNumeric ('#datastatus #totalstatusopd3',optionnumeric); 
    }
    if (checkExistsID('#datastatus #totalstatusopd'))
    {
        $('#datastatus #totalstatusopd').html(totalpaguindikatif.total);                
        new AutoNumeric ('#datastatus #totalstatusopd',optionnumeric);        
    }
    
}

function formatPaguTotalIndikatifUnitKerja(totalpaguindikatif)
{
    var optionnumeric =  {
                            allowDecimalPadding: false,
                            decimalCharacter: ",",
                            digitGroupSeparator: ".",
                            showWarnings:false
                        };

    if (checkExistsID('#datastatus #totalstatusunitkerja0'))
    {
        $('#datastatus #totalstatusunitkerja0').html(totalpaguindikatif[0]);                
        new AutoNumeric ('#datastatus #totalstatusunitkerja0',optionnumeric); 
    }    
    if (checkExistsID('#datastatus #totalstatusunitkerja1'))
    {
        $('#datastatus #totalstatusunitkerja1').html(totalpaguindikatif[1]);                        
        new AutoNumeric ('#datastatus #totalstatusunitkerja1',optionnumeric); 
    }    
    if (checkExistsID('#datastatus #totalstatusunitkerja2'))
    {
        $('#datastatus #totalstatusunitkerja2').html(totalpaguindikatif[2]); 
        new AutoNumeric ('#datastatus #totalstatusunitkerja2',optionnumeric);        
    }
    if (checkExistsID('#datastatus #totalstatusunitkerja12'))
    {
        $('#datastatus #totalstatusunitkerja12').html(parseFloat(totalpaguindikatif[1])+parseFloat(totalpaguindikatif[2]));        
        new AutoNumeric ('#datastatus #totalstatusunitkerja12',optionnumeric);        
    }
    if (checkExistsID('#datastatus #totalstatusunitkerja3'))
    {
        $('#datastatus #totalstatusunitkerja3').html(totalpaguindikatif[3]);        
        new AutoNumeric ('#datastatus #totalstatusunitkerja3',optionnumeric); 
    }
    if (checkExistsID('#datastatus #totalstatusunitkerja'))
    {
        $('#datastatus #totalstatusunitkerja').html(totalpaguindikatif.total);                
        new AutoNumeric ('#datastatus #totalstatusunitkerja',optionnumeric);        
    }   
}

function formatPaguRKPDMurniOPD(totalpagu)
{
    var optionnumeric =  {
                            allowDecimalPadding: false,
                            decimalCharacter: ",",
                            digitGroupSeparator: ".",
                            showWarnings:false
                        };
    
    if (checkExistsID('#datapagu #totalpagumurniopd'))
    {
        $('#datapagu #totalpagumurniopd').html(totalpagu['murni']);                
        new AutoNumeric ('#datapagu #totalpagumurniopd',optionnumeric); 
    }   
}

function formatPaguRKPDMurniUnitKerja(totalpagu)
{
    var optionnumeric =  {
                            allowDecimalPadding: false,
                            decimalCharacter: ",",
                            digitGroupSeparator: ".",
                            showWarnings:false
                        };
    
    if (checkExistsID('#datapagu #totalpagumurniunitkerja'))
    {
        $('#datapagu #totalpagumurniunitkerja').html(totalpagu['murni']);                
        new AutoNumeric ('#datapagu #totalpagumurniunitkerja',optionnumeric); 
    }       
}

function formatPaguRKPDPerubahanOPD(totalpagu)
{
    var optionnumeric =  {
                            allowDecimalPadding: false,
                            decimalCharacter: ",",
                            digitGroupSeparator: ".",
                            showWarnings:false
                        };
    
    if (checkExistsID('#datapagu #totalpagumurniopd'))
    {
        $('#datapagu #totalpagumurniopd').html(totalpagu['murni']);                
        new AutoNumeric ('#datapagu #totalpagumurniopd',optionnumeric); 
    }    
    if (checkExistsID('#datapagu #totalpaguperubahanopd'))
    {
        $('#datapagu #totalpaguperubahanopd').html(totalpagu['perubahan']);                        
        new AutoNumeric ('#datapagu #totalpaguperubahanopd',optionnumeric); 
    }    
    if (checkExistsID('#datapagu #selisihopd'))
    {
        $('#datapagu #selisihopd').html(totalpagu['selisih']);                        
        new AutoNumeric ('#datapagu #selisihopd',optionnumeric); 
    }    
    if (checkExistsID('#datapagu #pembahasanpopd'))
    {
        $('#datapagu #pembahasanpopd').html(totalpagu['pembahasanp']);                        
        new AutoNumeric ('#datapagu #pembahasanpopd',optionnumeric); 
    }    
    if (checkExistsID('#datapagu #selisihppopd'))
    {
        $('#datapagu #selisihppopd').html(totalpagu['selisihpp']);                        
        new AutoNumeric ('#datapagu #selisihppopd',optionnumeric); 
    }    
}
function formatPaguRKPDPerubahanUnitKerja(totalpagu)
{
    var optionnumeric =  {
                            allowDecimalPadding: false,
                            decimalCharacter: ",",
                            digitGroupSeparator: ".",
                            showWarnings:false
                        };
    
    if (checkExistsID('#datapagu #totalpagumurniunitkerja'))
    {
        $('#datapagu #totalpagumurniunitkerja').html(totalpagu['murni']);                
        new AutoNumeric ('#datapagu #totalpagumurniunitkerja',optionnumeric); 
    }    
    if (checkExistsID('#datapagu #totalpaguperubahanunitkerja'))
    {
        $('#datapagu #totalpaguperubahanunitkerja').html(totalpagu['perubahan']);                        
        new AutoNumeric ('#datapagu #totalpaguperubahanunitkerja',optionnumeric); 
    }    
    if (checkExistsID('#datapagu #selisihunitkerja'))
    {
        $('#datapagu #selisihunitkerja').html(totalpagu['selisih']);                        
        new AutoNumeric ('#datapagu #selisihunitkerja',optionnumeric); 
    }    
    if (checkExistsID('#datapagu #pembahasanpunitkerja'))
    {
        $('#datapagu #pembahasanpunitkerja').html(totalpagu['pembahasanp']);                        
        new AutoNumeric ('#datapagu #pembahasanpunitkerja',optionnumeric); 
    }    
    if (checkExistsID('#datapagu #selisihppunitkerja'))
    {
        $('#datapagu #selisihppunitkerja').html(totalpagu['selisihpp']);                        
        new AutoNumeric ('#datapagu #selisihppunitkerja',optionnumeric); 
    }    
}
//checking data type is json
function isJSON (data) 
{
    try 
    {
        JSON.parse(data);        
    }catch(e) 
    {
        return false;
    }
    return true;
}
//parsing ajax error
function parseMessageAjaxEror (xhr, status, error) 
{    
    if (isJSON(xhr)) {
        var jsonResponseText = $.parseJSON(xhr.responseText);
        var jsonResponseStatus = '';
        var message = '';

        $.each(jsonResponseText, function(name, val) 
        {
            switch(name) 
            {
                case 'message' :
                    message = 'message:' + val + ',';
                break;
                case 'exception' :
                    message = message + 'exception:' + val;
                break;
            }            
        });
        return message;
    }
}
/**
* data table function 
*/
//paginate table data
function paginateTableData (selector,href)
{
    var a =  href.attr('href').split('?page=');        
    var page = a[1];
    var page_url = a[0]+'/paginate/'+page;
    if (typeof page !== 'undefined')
    {
        $.ajax({
            type:'get',
            url: page_url,
            dataType: 'json',
            success:function(result)
            {          
                $(selector).html(result.datatable); 
                if ($(selector + ' *').hasClass('select')) {
                    //styling select
                    $('.select').select2({
                        allowClear:true
                    });
                };
                if ($(selector + ' *').hasClass('switch')) {
                    $(".switch").bootstrapSwitch();
                } 
            },
            error:function(xhr, status, error)
            {
                console.log('ERROR');
                console.log(parseMessageAjaxEror(xhr, status, error));                           
            },
        });
    }
}
 //change number record of page function
 function changeNumberRecordOfPage (selector)
 {
     $.ajax({
         type:'post',
         url: url_current_page +'/changenumberrecordperpage',
         dataType: 'json',
         data: {                
             "_token": token,
             "numberRecordPerPage": $('#numberRecordPerPage').val(),
         },
         success:function(result)
         {          
            $(selector).html(result.datatable);    
            if ($(selector + ' *').hasClass('select')) {
                //styling select
                $('.select').select2({
                    allowClear:true
                });
            }        
            if ($(selector + ' *').hasClass('switch')) {
                $(".switch").bootstrapSwitch();                
            }                       
         },
         error:function(xhr, status, error)
         {
             console.log('ERROR');
             console.log(parseMessageAjaxEror(xhr, status, error));                           
         },
     });
 }
 //sorting table data
 function sortingTableData (selector,a)
 {
     var column_name=a.attr('id');        
     var orderby=a.data('order');
     $.ajax({
        type:'post',
        url: url_current_page +'/orderby',
        dataType: 'json',
        data: {                
            "_token": token,                
            "column_name":column_name,
            "orderby": orderby,
        },
        success:function(result)
        {          
            $(selector).html(result.datatable);  
            if ($(selector + ' *').hasClass('select')) {
                //styling select                    
                $('.select').select2({
                    allowClear:true
                });
            }           
            if ($(selector + ' *').hasClass('switch')) {
                $(".switch").bootstrapSwitch();                
            } 
        },
        error:function(xhr, status, error)
        {
            console.log('ERROR');
            console.log(parseMessageAjaxEror(xhr, status, error));                           
        },
     });
 }    

document.addEventListener('DOMContentLoaded', function() {
    /**
     *  customization limitless menu
     */
    $('div.dropdown-menu li').filter(function() {
        return this.className == 'active';
    }).parents('.dropdown').addClass('active');

    // To make Pace works on Ajax calls
    $(document).ajaxStart(function () {
        Pace.restart()
    });    
    
    /**
     *  customization jquery-validation
     */
    if ($.validator) //check jquery-validation has loaded
    {    
        //override default value
        $.validator.setDefaults({
            errorElement: "span",
            errorClass: "help-block", 
            highlight:function (element) 
            {
                $(element).closest('.form-group').addClass('has-error');
            },    
            unhighlight:function (element) 
            {
                $(element).closest('.form-group').removeClass('has-error');
            },           
            errorPlacement: function ( error, element )  
            {
                if (element.parent('.input-group').length) 
                {
                    error.insertAfter(element.parent());
                }else
                {
                    error.insertAfter(element);
                }         
            },
        });
        //method value not equal
        $.validator.addMethod('valueNotEquals',function(value,element,arg){
            return arg !== value;
        }, "Value must not equal arg.");
        //method check if greater than or equal
        $.validator.addMethod('greaterthanorequal',function(value,element,arg){            
            return parseInt(value) >= parseInt(arg); 
        },'value must greater than or equal.');
        //method check if less than or equal
        $.validator.addMethod('lessthanorequal',function(value,element,arg){            
            return parseInt(value) <= parseInt(arg);  
        },'value must less than or equal.');
    }
    /**
    * form operations
    */ 
    if ($('#frmsearch').is("#frmsearch")) 
    {
        $('#frmsearch').submit (function(e) {
            e.preventDefault();
            var actionurl = e.currentTarget.action;     
            
            $.ajax({
                type:'post',
                url:actionurl,
                dataType: 'json',
                data: $("#frmsearch").serialize(),
                success:function(result){ 
                    $('#divdatatable').html(result.datatable);     
                    if ($('#divdatatable *').hasClass('select')) {
                        //styling select
                        $('.select').select2({
                            allowClear:true
                        });
                    }                  
                    if ($('#divdatatable *').hasClass('switch')) {
                        $(".switch").bootstrapSwitch();                
                    } 
                },
                error:function(xhr, status, error){
                    console.log('ERROR');
                    console.log(parseMessageAjaxEror(xhr, status, error));                           
                },
            });
        });
        $('#btnReset').click(function(ev) 
        {
            $('#frmsearch').trigger('reset');
            $('#txtKriteria').focus();
            $.ajax({
                type:'post',
                url: $('#frmsearch').attr('action'),
                dataType: 'json',
                data: {                
                    "_token": token,
                    "action": 'reset',
                },
                success:function(result){ 
                    $('#divdatatable').html(result.datatable);    
                    $('#txtKriteria').val('');     
                    if ($('#divdatatable *').hasClass('select')) {
                        //styling select
                        $('.select').select2({
                            allowClear:true
                        });
                    }              
                    if ($('#divdatatable *').hasClass('switch')) {
                        $(".switch").bootstrapSwitch();                
                    } 
                },
                error:function(xhr, status, error){
                    console.log('ERROR');
                    console.log(parseMessageAjaxEror(xhr, status, error));                           
                },
            });
        });
    }  

    /**
    * data table operations
    */

    //change number record of page
    $(document).on('change','#numberRecordPerPage', function (ev)
    {
        ev.preventDefault();    
        changeNumberRecordOfPage('#divdatatable');
    });
    //sorting table data
    $(document).on('click','.column-sort', function (ev)
    {
        ev.preventDefault();          
        sortingTableData ('#divdatatable',$(this));
    });
    //paginate table data
    $(document).on('click','#paginations a', function (ev)
    {
        ev.preventDefault();
        paginateTableData('#divdatatable',$(this));
    });

    // Disable CSS transitions on page load
    $('body').addClass('no-transitions');

    // ========================================
    //
    // Content area height
    //
    // ========================================


    // Calculate min height
    function containerHeight() {
        var pageContainerClass = 'page-container',
            bottomNavbarClass = 'navbar-fixed-bottom',
            bottomNavbar = $('.' + bottomNavbarClass).length && $('.' + bottomNavbarClass).outerHeight(),
            availableHeight = $(window).height() - $('.' + pageContainerClass).offset().top - bottomNavbar;

        $('.' + pageContainerClass).attr('style', 'min-height:' + availableHeight + 'px');
    }

    // Initialize
    containerHeight();




    // ========================================
    //
    // Heading elements
    //
    // ========================================


    // Heading elements toggler
    // -------------------------

    // Add control button toggler to page and panel headers if have heading elements
    $('.panel-footer').has('> .heading-elements:not(.not-collapsible)').prepend('<a class="heading-elements-toggle"><i class="icon-more"></i></a>');
    $('.page-title, .panel-title').parent().has('> .heading-elements:not(.not-collapsible)').children('.page-title, .panel-title').append('<a class="heading-elements-toggle"><i class="icon-more"></i></a>');


    // Toggle visible state of heading elements
    $('.page-title .heading-elements-toggle, .panel-title .heading-elements-toggle').on('click', function() {
        $(this).parent().parent().toggleClass('has-visible-elements').children('.heading-elements').toggleClass('visible-elements');
    });
    $('.panel-footer .heading-elements-toggle').on('click', function() {
        $(this).parent().toggleClass('has-visible-elements').children('.heading-elements').toggleClass('visible-elements');
    });



    // Breadcrumb elements toggler
    // -------------------------

    // Add control button toggler to breadcrumbs if has elements
    $('.breadcrumb-line').has('.breadcrumb-elements').prepend('<a class="breadcrumb-elements-toggle"><i class="icon-menu-open"></i></a>');


    // Toggle visible state of breadcrumb elements
    $('.breadcrumb-elements-toggle').on('click', function() {
        $(this).parent().children('.breadcrumb-elements').toggleClass('visible-elements');
    });




    // ========================================
    //
    // Navbar
    //
    // ========================================


    // Navbar navigation
    // -------------------------

    // Prevent dropdown from closing on click
    $(document).on('click', '.dropdown-content', function (e) {
        e.stopPropagation();
    });

    // Disabled links
    $('.navbar-nav .disabled a').on('click', function (e) {
        e.preventDefault();
        e.stopPropagation();
    });

    // Show tabs inside dropdowns
    $('.dropdown-content a[data-toggle="tab"]').on('click', function (e) {
        $(this).tab('show');
    });



    // Drill down menu
    // ------------------------------

    // If menu has child levels, add selector class
    $('.menu-list').find('li').has('ul').parents('.menu-list').addClass('has-children');

    // Attach drill down menu to menu list with child levels
    $('.has-children').dcDrilldown({
        defaultText: 'Back to parent',
        saveState: true
    });




    // ========================================
    //
    // Element controls
    //
    // ========================================


    // Reload elements
    // -------------------------

    // Panels
    $('.panel [data-action=reload]').click(function (e) {
        e.preventDefault();
        var block = $(this).parent().parent().parent().parent().parent();
        $(block).block({ 
            message: '<i class="icon-spinner2 spinner"></i>',
            overlayCSS: {
                backgroundColor: '#fff',
                opacity: 0.8,
                cursor: 'wait',
                'box-shadow': '0 0 0 1px #ddd'
            },
            css: {
                border: 0,
                padding: 0,
                backgroundColor: 'none'
            }
        });

        // For demo purposes
        window.setTimeout(function () {
           $(block).unblock();
        }, 2000); 
    });


    // Sidebar categories
    $('.category-title [data-action=reload]').click(function (e) {
        e.preventDefault();
        var block = $(this).parent().parent().parent().parent();
        $(block).block({ 
            message: '<i class="icon-spinner2 spinner"></i>',
            overlayCSS: {
                backgroundColor: '#000',
                opacity: 0.5,
                cursor: 'wait',
                'box-shadow': '0 0 0 1px #000'
            },
            css: {
                border: 0,
                padding: 0,
                backgroundColor: 'none',
                color: '#fff'
            }
        });

        // For demo purposes
        window.setTimeout(function () {
           $(block).unblock();
        }, 2000); 
    }); 


    // Light sidebar categories
    $('.sidebar-default .category-title [data-action=reload]').click(function (e) {
        e.preventDefault();
        var block = $(this).parent().parent().parent().parent();
        $(block).block({ 
            message: '<i class="icon-spinner2 spinner"></i>',
            overlayCSS: {
                backgroundColor: '#fff',
                opacity: 0.8,
                cursor: 'wait',
                'box-shadow': '0 0 0 1px #ddd'
            },
            css: {
                border: 0,
                padding: 0,
                backgroundColor: 'none'
            }
        });

        // For demo purposes
        window.setTimeout(function () {
           $(block).unblock();
        }, 2000); 
    }); 



    // Collapse elements
    // -------------------------

    //
    // Sidebar categories
    //

    // Hide if collapsed by default
    $('.category-collapsed').children('.category-content').hide();


    // Rotate icon if collapsed by default
    $('.category-collapsed').find('[data-action=collapse]').addClass('rotate-180');


    // Collapse on click
    $('.category-title [data-action=collapse]').click(function (e) {
        e.preventDefault();
        var $categoryCollapse = $(this).parent().parent().parent().nextAll();
        $(this).parents('.category-title').toggleClass('category-collapsed');
        $(this).toggleClass('rotate-180');

        containerHeight(); // adjust page height

        $categoryCollapse.slideToggle(150);
    });


    //
    // Panels
    //

    // Hide if collapsed by default
    $('.panel-collapsed').children('.panel-heading').nextAll().hide();


    // Rotate icon if collapsed by default
    $('.panel-collapsed').find('[data-action=collapse]').addClass('rotate-180');


    // Collapse on click
    $('.panel [data-action=collapse]').click(function (e) {
        e.preventDefault();
        var $panelCollapse = $(this).parent().parent().parent().parent().nextAll();
        $(this).parents('.panel').toggleClass('panel-collapsed');
        $(this).toggleClass('rotate-180');

        containerHeight(); // recalculate page height

        $panelCollapse.slideToggle(150);
    });



    // Remove elements
    // -------------------------

    // Panels
    $('.panel [data-action=close]').click(function (e) {
        e.preventDefault();
        var $panelClose = $(this).parent().parent().parent().parent().parent();

        containerHeight(); // recalculate page height

        $panelClose.slideUp(150, function() {
            $(this).remove();
        });
    });


    // Sidebar categories
    $('.category-title [data-action=close]').click(function (e) {
        e.preventDefault();
        var $categoryClose = $(this).parent().parent().parent().parent();

        containerHeight(); // recalculate page height

        $categoryClose.slideUp(150, function() {
            $(this).remove();
        });
    });




    // ========================================
    //
    // Main navigation
    //
    // ========================================


    // Main navigation
    // -------------------------

    // Add 'active' class to parent list item in all levels
    $('.navigation').find('li.active').parents('li').addClass('active');

    // Hide all nested lists
    $('.navigation').find('li').not('.active, .category-title').has('ul').children('ul').addClass('hidden-ul');

    // Highlight children links
    $('.navigation').find('li').has('ul').children('a').addClass('has-ul');

    // Add active state to all dropdown parent levels
    $('.dropdown-menu:not(.dropdown-content), .dropdown-menu:not(.dropdown-content) .dropdown-submenu').has('li.active').addClass('active').parents('.navbar-nav .dropdown:not(.language-switch), .navbar-nav .dropup:not(.language-switch)').addClass('active');

    

    // Main navigation tooltips positioning
    // -------------------------

    // Left sidebar
    $('.navigation-main > .navigation-header > i').tooltip({
        placement: 'right',
        container: 'body'
    });



    // Collapsible functionality
    // -------------------------

    // Main navigation
    $('.navigation-main').find('li').has('ul').children('a').on('click', function (e) {
        e.preventDefault();

        // Collapsible
        $(this).parent('li').not('.disabled').not($('.sidebar-xs').not('.sidebar-xs-indicator').find('.navigation-main').children('li')).toggleClass('active').children('ul').slideToggle(250);

        // Accordion
        if ($('.navigation-main').hasClass('navigation-accordion')) {
            $(this).parent('li').not('.disabled').not($('.sidebar-xs').not('.sidebar-xs-indicator').find('.navigation-main').children('li')).siblings(':has(.has-ul)').removeClass('active').children('ul').slideUp(250);
        }
    });

        
    // Alternate navigation
    $('.navigation-alt').find('li').has('ul').children('a').on('click', function (e) {
        e.preventDefault();

        // Collapsible
        $(this).parent('li').not('.disabled').toggleClass('active').children('ul').slideToggle(200);

        // Accordion
        if ($('.navigation-alt').hasClass('navigation-accordion')) {
            $(this).parent('li').not('.disabled').siblings(':has(.has-ul)').removeClass('active').children('ul').slideUp(200);
        }
    }); 




    // ========================================
    //
    // Sidebars
    //
    // ========================================


    // Mini sidebar
    // -------------------------

    // Toggle mini sidebar
    $('.sidebar-main-toggle').on('click', function (e) {
        e.preventDefault();

        // Toggle min sidebar class
        $('body').toggleClass('sidebar-xs');
    });



    // Sidebar controls
    // -------------------------

    // Disable click in disabled navigation items
    $(document).on('click', '.navigation .disabled a', function (e) {
        e.preventDefault();
    });


    // Adjust page height on sidebar control button click
    $(document).on('click', '.sidebar-control', function (e) {
        containerHeight();
    });


    // Hide main sidebar in Dual Sidebar
    $(document).on('click', '.sidebar-main-hide', function (e) {
        e.preventDefault();
        $('body').toggleClass('sidebar-main-hidden');
    });


    // Toggle second sidebar in Dual Sidebar
    $(document).on('click', '.sidebar-secondary-hide', function (e) {
        e.preventDefault();
        $('body').toggleClass('sidebar-secondary-hidden');
    });


    // Hide all sidebars
    $(document).on('click', '.sidebar-all-hide', function (e) {
        e.preventDefault();

        $('body').toggleClass('sidebar-all-hidden');
    });



    //
    // Opposite sidebar
    //

    // Collapse main sidebar if opposite sidebar is visible
    $(document).on('click', '.sidebar-opposite-toggle', function (e) {
        e.preventDefault();

        // Opposite sidebar visibility
        $('body').toggleClass('sidebar-opposite-visible');

        // If visible
        if ($('body').hasClass('sidebar-opposite-visible')) {

            // Make main sidebar mini
            $('body').addClass('sidebar-xs');

            // Hide children lists
            $('.navigation-main').children('li').children('ul').css('display', '');
        }
        else {

            // Make main sidebar default
            $('body').removeClass('sidebar-xs');
        }
    });


    // Hide main sidebar if opposite sidebar is shown
    $(document).on('click', '.sidebar-opposite-main-hide', function (e) {
        e.preventDefault();

        // Opposite sidebar visibility
        $('body').toggleClass('sidebar-opposite-visible');
        
        // If visible
        if ($('body').hasClass('sidebar-opposite-visible')) {

            // Hide main sidebar
            $('body').addClass('sidebar-main-hidden');
        }
        else {

            // Show main sidebar
            $('body').removeClass('sidebar-main-hidden');
        }
    });


    // Hide secondary sidebar if opposite sidebar is shown
    $(document).on('click', '.sidebar-opposite-secondary-hide', function (e) {
        e.preventDefault();

        // Opposite sidebar visibility
        $('body').toggleClass('sidebar-opposite-visible');

        // If visible
        if ($('body').hasClass('sidebar-opposite-visible')) {

            // Hide secondary
            $('body').addClass('sidebar-secondary-hidden');

        }
        else {

            // Show secondary
            $('body').removeClass('sidebar-secondary-hidden');
        }
    });


    // Hide all sidebars if opposite sidebar is shown
    $(document).on('click', '.sidebar-opposite-hide', function (e) {
        e.preventDefault();

        // Toggle sidebars visibility
        $('body').toggleClass('sidebar-all-hidden');

        // If hidden
        if ($('body').hasClass('sidebar-all-hidden')) {

            // Show opposite
            $('body').addClass('sidebar-opposite-visible');

            // Hide children lists
            $('.navigation-main').children('li').children('ul').css('display', '');
        }
        else {

            // Hide opposite
            $('body').removeClass('sidebar-opposite-visible');
        }
    });


    // Keep the width of the main sidebar if opposite sidebar is visible
    $(document).on('click', '.sidebar-opposite-fix', function (e) {
        e.preventDefault();

        // Toggle opposite sidebar visibility
        $('body').toggleClass('sidebar-opposite-visible');
    });



    // Mobile sidebar controls
    // -------------------------

    // Toggle main sidebar
    $('.sidebar-mobile-main-toggle').on('click', function (e) {
        e.preventDefault();
        $('body').toggleClass('sidebar-mobile-main').removeClass('sidebar-mobile-secondary sidebar-mobile-opposite');
    });


    // Toggle secondary sidebar
    $('.sidebar-mobile-secondary-toggle').on('click', function (e) {
        e.preventDefault();
        $('body').toggleClass('sidebar-mobile-secondary').removeClass('sidebar-mobile-main sidebar-mobile-opposite');
    });


    // Toggle opposite sidebar
    $('.sidebar-mobile-opposite-toggle').on('click', function (e) {
        e.preventDefault();
        $('body').toggleClass('sidebar-mobile-opposite').removeClass('sidebar-mobile-main sidebar-mobile-secondary');
    });



    // Mobile sidebar setup
    // -------------------------

    $(window).on('resize', function() {
        setTimeout(function() {
            containerHeight();
            
            if($(window).width() <= 768) {

                // Add mini sidebar indicator
                $('body').addClass('sidebar-xs-indicator');

                // Place right sidebar before content
                $('.sidebar-opposite').prependTo('.page-content');

                // Remove nicescroll on mobiles
                $('.menu-list').getNiceScroll().remove();
                $(".menu-list").removeAttr('style').removeAttr('tabindex');

                // Add mouse events for dropdown submenus
                $('.dropdown-submenu-hover').on('mouseenter touchstart', function() {
                    $(this).children('.dropdown-menu').addClass('show');
                }).on('mouseleave touchend', function() {
                    $(this).children('.dropdown-menu').removeClass('show');
                });
            }
            else {

                // Remove mini sidebar indicator
                $('body').removeClass('sidebar-xs-indicator');

                // Revert back right sidebar
                $('.sidebar-opposite').insertAfter('.content-wrapper');

                // Remove all mobile sidebar classes
                $('body').removeClass('sidebar-mobile-main sidebar-mobile-secondary sidebar-mobile-opposite');

                // Initialize nicescroll on tablets+
                $(".menu-list").niceScroll({
                    mousescrollstep: 100,
                    cursorcolor: '#ccc',
                    cursorborder: '',
                    cursorwidth: 3,
                    hidecursordelay: 200,
                    autohidemode: 'scroll',
                    railpadding: { right: 0.5 }
                });

                // Remove visibility of heading elements on desktop
                $('.page-header-content, .panel-heading, .panel-footer').removeClass('has-visible-elements');
                $('.heading-elements').removeClass('visible-elements');

                // Disable appearance of dropdown submenus
                $('.dropdown-submenu').children('.dropdown-menu').removeClass('show');
            }
        }, 100);
    }).resize();

    // ========================================
    //
    // Other code
    //
    // ========================================


    // Clickable dropdown submenu
    // -------------------------

    // All parent levels require .dropdown-toggle class
    $('.dropdown-menu').find('.dropdown-submenu').not('.disabled').find('.dropdown-toggle').on('click', function(e) {
        e.stopPropagation();
        e.preventDefault();

        // Remove "open" class in all siblings
        $(this).parent().siblings().removeClass('open');

        // Toggle submenu
        $(this).parent().toggleClass('open');

        // Hide all levels when parent dropdown is closed
        $(this).parents('.open').on('hidden.bs.dropdown', function(e) {
            $('.dropdown-submenu.open').removeClass('open');
        });
    });


    // Plugins
    // -------------------------

    // Popover
    $('[data-popup="popover"]').popover();


    // Tooltip
    $('[data-popup="tooltip"]').tooltip();

});

// Allow CSS transitions when page is loaded
window.addEventListener('load', function() {
    $('body').removeClass('no-transitions');
});