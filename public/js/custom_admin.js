$(document).ready(function() {
    $( ".select2" ).select2();

    ClassicEditor
    .create( document.querySelector( '#editor' ) )
    .then( editor => {
        console.log( editor );
    })
    .catch( error => {
        console.error( error );
    });

    //For Order Detail Page
    $(".addMaterialCharge").click(function () {
        var inputText = "";
        inputText += '<div class="form-group col-md-12">';
        inputText += '<label>Material charge</label>';
        inputText += '<input type="number" name="material_charge" class="form-control" required />';
        inputText += '</div>';
        inputText += '<div class="form-group col-md-12">';
        inputText += '<label>Material charge (Actual)</label>';
        inputText += '<input type="number" name="material_charge_actual" class="form-control" required />';
        inputText += '</div>';
        inputText += '<div class="form-group col-md-12">';
        inputText += '<label>Material charge Description</label>';
        inputText += '<textarea name="material_description" class="form-control" required></textarea>';
        inputText += '</div>';
        $(".chargeTypeBtn").html("Add Material Charge");
        $("#chargeType").val("add_material_charge");
        $(".chargeModalInput").html(inputText);
        $("#addChargesMdl").modal("show");
    });
    $(".addAdditionalCharge").click(function () {
        var inputText = "";
        inputText += '<div class="form-group col-md-12">';
        inputText += '<label>Additional charge</label>';
        inputText += '<input type="number" name="additional_charge" class="form-control" required />';
        inputText += '</div>';
        inputText += '<div class="form-group col-md-12">';
        inputText += '<label>Additional charge Description</label>';
        inputText += '<textarea name="additional_charge_description" class="form-control" required></textarea>';
        inputText += '</div>';
        $(".chargeTypeBtn").html("Add Additional Charge");
        $("#chargeType").val("add_additional_charge");
        $(".chargeModalInput").html(inputText);
        $("#addChargesMdl").modal("show");
    });
});

/**
 * ------------------------------------------------------------------------
 *  Important Information
 *  Any Function should be written below this line
 * ------------------------------------------------------------------------
 */

/**
 * Function to generate the datatable
 *
 * @param string url
 * @param array coloumnsData
 * @param array filterData
 * @param array coloumnsData
 */
function generateDataTable(dataUrl, coloumnsData, filterData = [], coloumnsToExport = [1,2,3,4]) {

    $('#data-table').DataTable({
        processing: true,
        serverSide: true,
        pageLength: 15,
        bFilter: true,
        ajax: {
            url: dataUrl,
            data: function (d) {
                d.filterData = filterData;
            }
        },
        columns: coloumnsData,
        dom: 'Bfrtip',
        order: [],
        'columnDefs': [
            {
                "targets": 0,
                "className": "text-center",
                "width": "18%",
                orderable: false,
           },
        ],
        buttons: [
            {
                extend: 'pdfHtml5',
                exportOptions: {
                    columns: coloumnsToExport
                }
            },
            {
                extend: 'csvHtml5',
                exportOptions: {
                    columns: coloumnsToExport
                }
            },
            {
                extend: 'print',
                exportOptions: {
                    columns: coloumnsToExport
                }
            },
        ],
    });
}

/**
 * Function to remove Data from the database
 *
 * @param string deleteUrl
 * @param integer id
 */
function removeDataFromDatabase(deleteUrl, id, csrf) {
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        showCancelButton: true,
        icon: 'warning',
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.value) {
            $.ajax({
                type: "POST",
                dataType : 'json',
                url: deleteUrl + '/' + id,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    _method: 'DELETE'
                },
                beforeSend: function() {
                    Swal.fire('Please wait..','While we are removing your data !','info')
                },
                success : function(response) {
                    Swal.fire('Deleted','Data has been removed successfully !','success')
                    $('#data-table').DataTable().ajax.reload();
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    Swal.fire('Whoops !','We encoutered some error !<br>' + XMLHttpRequest.responseJSON.message,'error')
                }
            });
        }
    });
}


/**
 * Function to generate the pie chart
 *
 * @param string chartElement
 * @param array chartLabel
 * @param array chartData
 */
function generatPieChart(chartElement, chartLabel, chartData) {
    var pieChartCanvas = $('#' + chartElement).get(0).getContext('2d');

    new Chart(pieChartCanvas, {
        type: 'pie',
        data: {
            labels: chartLabel,
            datasets: chartData
        },
        options: {
            maintainAspectRatio : false,
            responsive : true,
        }
    });
}

/**
 * Function to generate the bar chart
 *
 * @param string chartElement
 * @param array chartLabel
 * @param array chartData
 */
function generatBarChart(chartElement, chartLabel, chartData) {
    var chartDataSet = [];
    var barChartCanvas = $('#' + chartElement).get(0).getContext('2d');

    chartData.forEach(function(row) {
        chartDataSet.push({
            label               : row.name,
            backgroundColor     : row.background,
            borderColor         : 'rgba(60,141,188,0.8)',
            pointRadius          : false,
            pointColor          : '#3b8bba',
            pointStrokeColor    : 'rgba(60,141,188,1)',
            pointHighlightFill  : '#fff',
            pointHighlightStroke: 'rgba(60,141,188,1)',
            data                : row.value
        })
    })

    var barChartData = $.extend(true, {}, {
        labels: chartLabel,
        datasets: chartDataSet
    })

    new Chart(barChartCanvas, {
        type: 'bar',
        data: barChartData,
        options: {
            responsive              : true,
            maintainAspectRatio     : false,
            datasetFill             : false
        }
    })
}

/**
 * Function to Fetch categories and set to option value
 *
 * @param int selected
 */
function fetchAndSetCategory(selected = '') {
    var options = "<option value=''>Select Category</option>";
    $.ajax({
        type : "GET",
        url : "/api/category",
        data : {},
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success : function(response) {
            if (response.success) {
                response.data.forEach(function (key) {
                    if (selected == key.id) {
                        options += "<option selected value='" + key.id + "'>" + key.name + "</option>";
                    } else {
                        options += "<option value='" + key.id + "'>" + key.name + "</option>";
                    }

                })
            }
            $("#category").html(options);
        }
    });
}

/**
 * Function to Fetch sub-categories and set to option value
 *
 * @param int cat
 * @param int selected
 */
function fetchAndSetSubCategory(cat, selected = '') {
    if (cat) {
        var options = "<option value=''>Select Sub Category</option>";
        $.ajax({
            type : "GET",
            url : "/api/subcategory",
            data : {
                category: cat
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success : function(response) {
                if (response.success) {
                    response.data.forEach(function (key) {
                        if (selected == key.id) {
                            options += "<option selected value='" + key.id + "'>" + key.name + "</option>";
                        } else {
                            options += "<option value='" + key.id + "'>" + key.name + "</option>";
                        }
                    })
                }
                $("#subcategory").html(options);
            }
        });
    }
}
