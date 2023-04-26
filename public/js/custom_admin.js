$(document).ready(function() {
    $( ".select2" ).select2();
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

    $('#data-table tfoot th').each( function (counter) {
		var title = $(this).text();
		var totalLen = $('#data-table tfoot th').length;
        if (counter == 0 || counter == (totalLen-1)) {
            $(this).html( '<input class="form-control" disabled type="text" />' );
        } else {
            $(this).html( '<input class="form-control" type="text" placeholder="'+ title +' Search" />' );
        }
	});

    var dtTable = $('#data-table').DataTable({
        processing: true,
        serverSide: true,
        pageLength: 15,
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

    dtTable.columns().every( function () {
		var that = this;
		$( 'input', this.footer() ).on( 'keyup change', function () {
			if ( that.search() !== this.value ) {
				that
					.search( this.value )
					.draw();
			}
		});
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
