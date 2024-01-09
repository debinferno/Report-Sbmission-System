/*(function ($) {
    $(function () {
        $('.table-expandable').each(function () {
            var table = $(this);
            table.children('thead').children('tr').append('<th></th>');
            table.children('tbody').children('tr').filter('#collapse').hide();
            var row = table.children('tbody').children('tr').filter('#expand');
            console.log(row);
            table.children('tbody').children('tr').filter('#expand').click(function () {
                var element = $(this);
                element.next('#collapse').toggle('slow');
                element.find(".table-expandable-arrow").toggleClass("up");
            });
            table.children('tbody').children('tr').filter('#expand').each(function () {
                var element = $(this);
                element.append('<td><div class="table-expandable-arrow"></div></td>');
            });
        });
    });
})(jQuery); */





(function ($) {
    $(function () {
        $('.table-expandable').each(function () {
            var table = $(this);
            table.children('thead').children('tr').append('<th></th>');
            var expandTable = $('.expandable-table').find('*');
            //expandTable.hide();
            var a=[];
            table.children('tbody').children('tr').filter('#expand').each(function() {
                var columnIndex = 0;
                var rowData = parseInt($(this).find('td').eq(columnIndex).text());
                a.push(rowData);
            })
            var arr=[];
            for (var i = 0; i < a.length; i++) {
                var expandableTable= expandTable.filter('#'+a[i]);                
                expandableTable.hide();
                arr.push(expandableTable);
              }
            //var expandableTable= expandTable.filter('#1').hide();          
            table.children('tbody').children('tr').filter('#expand').click(function () {
                var element = $(this);
                var columnIndex = 0;
                var columnData=element.find('td').eq(columnIndex).text();
                var rowIndex=parseInt(columnData);               
                var index=a.indexOf(rowIndex);
                console.log(index);
                var row=arr[index];
                element.after(row);
                row.toggle('slow');
                element.find(".table-expandable-arrow").toggleClass("up");
            });
            table.children('tbody').children('tr').filter('#expand').each(function () {
                var element = $(this);
                element.append('<td><div class="table-expandable-arrow"></div></td>');
            });
        });
    });
})(jQuery); 


/*$(function () {
    $('.table-expandable').on('click', '.expandable-arrow', function () {
      var arrow = $(this);
      var row = arrow.closest('tr');
      var expandedContent = row.next('.expanded-content');
  
      // Toggle the visibility of the expanded content
      expandedContent.toggle();
  
      // Change the arrow icon class based on visibility
      arrow.toggleClass('up', expandedContent.is(':visible'));
    });
  });



  $(document).ready(function() {
    // Find the table with ID "table2"
    var $tableId2 = $('#table2');
  
    // Get all rows of the table with ID "table2"
    var $rows = $tableId2.find('tr');
  
    // Create a new table row to be inserted after a specific row
    var newRowContent = '<td>New Row, Table 2</td>';
    var $newRow = $('<tr>').html(newRowContent);
  
    // Find the row after which the new row should be inserted (e.g., the 2nd row)
    var $insertAfterRow = $rows.eq(1); // Index is zero-based
  
    // Insert the new row after the specified row
    $insertAfterRow.after($newRow);
  });*/
  
  