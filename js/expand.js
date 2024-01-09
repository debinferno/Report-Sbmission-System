(function ($) {
    console.log("Hello, this is a message for the console!");
    $(function () {
        console.log("Hello, this is a message for the console!");
        $('.table-expandable').each(function () {
            var table = $(this);
            table.children('thead').children('tr').append('<th></th>');
            var expandTable = $('.expandable-table').find('*');
            //expandTable.hide();
            var a=[];
            table.children('tbody').children('tr').filter('#expand').each(function() {
                var columnIndex = 0;
                var rowData = $(this).find('th').eq(columnIndex).text();
                a.push(rowData);
                console.log(rowData);
            })
            var arr=[];
            for (var i = 0; i < a.length; i++) {
                var expandableTable= expandTable.filter('#'+a[i]);                
                expandableTable.hide();
                arr.push(expandableTable);
              }
            for (var i = 0; i < a.length; i++) {
                console.log(arr[i]);
            }
            //var expandableTable= expandTable.filter('#1').hide();          
            table.children('tbody').children('tr').filter('#expand').click(function () {
                console.log("Hello, this is a message for the console!");
                var element = $(this);
                var columnIndex = 0;
                var columnData=element.find('th').eq(columnIndex).text();
                //var rowIndex=new Date(columnData);               
                var index=a.indexOf(columnData);
                console.log(index);
                var row=arr[index];
                element.after(row);
                row.toggle('slow');
                element.find(".table-expandable-arrow").toggleClass("up");
            });
            table.children('tbody').children('tr').filter('#expand').each(function () {
                var element = $(this);
                element.append('<th><div class="table-expandable-arrow"></div></th>');
            });
        });
    });
})(jQuery); 





