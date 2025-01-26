<html>
    <!-- <title><?=$page_title?></title> -->
    <body onload="onload()">
        <div class="contentForm" style="font-size: medium;">
            <div id="body" style="overflow: hidden;">    
                <h3 class="card-title h2 font-weight-bolder" style="text-align: center !important;">{{ $page_title }}</h3>
                 <p style="text-align: center;">মামলা নম্বর: <span id="paymentCaseNo">{{ $caseNumber }}</span></p>
                <table border="1" style="border-collapse: collapse;" width="100%">
                    <thead>
                        <tr>
                            <th class="wide-10">ক্রমিক</th>
                            <th class="wide-10">জমা/কিস্তি </th>
                            <th class="wide-10">তারিখ</th>
                            <th class="wide-10">নিলামে বিক্রিত অর্থ</th>
                            <th class="wide-10">নিলামের তারিখ </th>
                            <th class="wide-10">নিলাম কারীর নাম</th>
                            <th class="wide-10">নিলাম গ্রহীতার নাম</th>
                            <th class="wide-10">সূত্র/রশিদ নম্বর</th>
                            
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($paymentList as $key => $val)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $val->paid_loan_amount }}</td>
                            <td>{{ $val->paid_date }}</td>
                            <td>{{ $val->auctioned_sale }}</td>
                            <td>{{ $val->auctioned_date }}</td>
                            <td>{{ $val->auctioneer_name }}</td>
                            <td>{{ $val->auctioneer_recipient_name }}</td>
                            <td>{{ $val->receipt_no }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </body>    
        <script>
            function onload() {
               window.print()
            }  
        </script>


</html>   
