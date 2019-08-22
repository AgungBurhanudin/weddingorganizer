<?php

namespace Libraries;

use Resources;

class SimulatorHpay {

    public static function plnpostpaid($jenis) {
        if($jenis == 'inq'){
            //3bulan
//            $response = '{"content":{"billStatus":"3","postpaidBillInfos":[{"billPeriod":"201801","currentMeterReading1":"16948","currentMeterReading2":"0","currentMeterReading3":"0","dueDate":"20012018","incentive":"D0000000000","meterReadDate":"00000000","penaltyFee":"9000","previousMeterReading1":"16759","previousMeterReading2":"0","previousMeterReading3":"0","totalElectricityBill":"000000093143","valueAddedTax":"0"},{"billPeriod":"201802","currentMeterReading1":"17138","currentMeterReading2":"0","currentMeterReading3":"0","dueDate":"20022018","incentive":"D0000000000","meterReadDate":"00000000","penaltyFee":"6000","previousMeterReading1":"16948","previousMeterReading2":"0","previousMeterReading3":"0","totalElectricityBill":"000000093687","valueAddedTax":"0"},{"billPeriod":"201803","currentMeterReading1":"17335","currentMeterReading2":"0","currentMeterReading3":"0","dueDate":"20032018","incentive":"D0000000000","meterReadDate":"00000000","penaltyFee":"0","previousMeterReading1":"17138","previousMeterReading2":"0","previousMeterReading3":"0","totalElectricityBill":"000000097499","valueAddedTax":"0"}],"powerConsumingCategory":"450","serviceUnit":"12616","serviceUnitPhone":"123            ","subscriberId":"126160167542","subscriberName":"PAITIK                   ","subscriberSegmentation":"  R1","switcherId":"0000000","switcherRefNum":"3CBA50B09A5346BD9AC0000000000000","totalAdminCharges":"0","totalAmount":"299329","totalOutstandingBill":"3"},"responseCode":"00","responseMessage":"OK","trxId":"000013184234"}';
            $response = '{"content":{"billStatus":"1","postpaidBillInfos":{"billPeriod":"201803","currentMeterReading1":"55810","currentMeterReading2":"0","currentMeterReading3":"0","dueDate":"20032018","incentive":"D0000000000","meterReadDate":"00000000","penaltyFee":"0","previousMeterReading1":"55590","previousMeterReading2":"0","previousMeterReading3":"0","totalElectricityBill":"000000345170","valueAddedTax":"0"},"powerConsumingCategory":"2200","serviceUnit":"53571","serviceUnitPhone":"123            ","subscriberId":"535713919055","subscriberName":"DUDUNG SUJANA            ","subscriberSegmentation":"  R1","switcherId":"0000000","switcherRefNum":"EDF06491EBA04D2A9250000000000000","totalAdminCharges":"0","totalAmount":"345170","totalOutstandingBill":"1"},"responseCode":"00","responseMessage":"OK","trxId":"000013191149"}';
            
        }else{
//            $response = '{"content":{"infoText":"Informasi Hubungi Call Center 123 Atau Hub PLN Terdekat","billStatus":"3","postpaidBillInfos":[{"billPeriod":"201801","currentMeterReading1":"16948","currentMeterReading2":"0","currentMeterReading3":"0","dueDate":"20012018","incentive":"D0000000000","meterReadDate":"00000000","penaltyFee":"9000","previousMeterReading1":"16759","previousMeterReading2":"0","previousMeterReading3":"0","totalElectricityBill":"000000093143","valueAddedTax":"0"},{"billPeriod":"201802","currentMeterReading1":"17138","currentMeterReading2":"0","currentMeterReading3":"0","dueDate":"20022018","incentive":"D0000000000","meterReadDate":"00000000","penaltyFee":"6000","previousMeterReading1":"16948","previousMeterReading2":"0","previousMeterReading3":"0","totalElectricityBill":"000000093687","valueAddedTax":"0"},{"billPeriod":"201803","currentMeterReading1":"17335","currentMeterReading2":"0","currentMeterReading3":"0","dueDate":"20032018","incentive":"D0000000000","meterReadDate":"00000000","penaltyFee":"0","previousMeterReading1":"17138","previousMeterReading2":"0","previousMeterReading3":"0","totalElectricityBill":"000000097499","valueAddedTax":"0"}],"powerConsumingCategory":"450","serviceUnit":"12616","serviceUnitPhone":"123            ","subscriberId":"126160167542","subscriberName":"PAITIK                   ","subscriberSegmentation":"  R1","switcherId":"0000000","switcherRefNum":"3CBA50B09A5346BD9AC0000000000000","totalAdminCharges":"0","totalAmount":"299329","totalOutstandingBill":"3"},"responseCode":"00","responseMessage":"OK","trxId":"000013184234"}';
            $response = '{"content":{"infoText":"Informasi Hubungi Call Center 123 Atau Hub PLN Terdekat","billStatus":"1","postpaidBillInfos":{"billPeriod":"201803","currentMeterReading1":"55810","currentMeterReading2":"0","currentMeterReading3":"0","dueDate":"20032018","incentive":"D0000000000","meterReadDate":"00000000","penaltyFee":"0","previousMeterReading1":"55590","previousMeterReading2":"0","previousMeterReading3":"0","totalElectricityBill":"000000345170","valueAddedTax":"0"},"powerConsumingCategory":"2200","serviceUnit":"53571","serviceUnitPhone":"123            ","subscriberId":"535713919055","subscriberName":"DUDUNG SUJANA            ","subscriberSegmentation":"  R1","switcherId":"0000000","switcherRefNum":"EDF06491EBA04D2A9250000000000000","totalAdminCharges":"0","totalAmount":"345170","totalOutstandingBill":"1"},"responseCode":"00","responseMessage":"OK","trxId":"000013191149"}';
        }
        return $response;
    }
    
    public static function plnprepaid($jenis) {
        if($jenis == 'inq'){
            $response = '{"content":{"adminCharge":"0","distributionCode":"52","flag":"1","maxKWHLimit":"648","meterSerialNumber":"56600276184","minorUnitofAdminCharge":"2","plnRefNumber":{"0":"                                "},"powerConsumingCategory":"000000900","serviceUnit":"52351","serviceUnitPhone":"123            ","subscriberId":"523511732557","subscriberName":"M. MUQTAFIN ABDULLAH     ","subscriberSegmentation":"R1M ","swRefNumber":"0AE0C6E59B93484CB700000000000000","switcherId":"0000000","totalAmount":"0","totalRepeat":"0"},"responseCode":"00","responseMessage":"OK","trxId":"000013184166"}';
        }else{
            $response = '{"content":{"infoText":"Informasi Hubungi Call Center 123 Atau Hub PLN Terdekat","adminCharge":"250000","buyingOptions":"0","customerPayablesInstallment":"0","distributionCode":"43","flag":"0","infoText":"Informasi Hubungi Call Center 123 Atau hubungi PLN Terdekat ","inquiryRefNumber":"E4A1D3AC0EBF43B39D50000000000000","maxKWHLimit":"936","meterSerialNumber":"14042389107","minorUnitCustomerPayablesInstallment":"2","minorUnitOfPowerPurchase":"2","minorUnitOfPublicLightingTax":"2","minorUnitOfPurchasedKWHUnit":"2","minorUnitOfValueAddedTax":"2","minorUnitStampDuty":"2","minorUnitofAdminCharge":"2","plnRefNumber":{},"powerConsumingCategory":"000001300","powerPurchase":"1851800","publicLightingTax":"148200","purchaseKWHUnit":"1270","serviceUnit":"43570","serviceUnitPhone":"123            ","stampDuty":"0","subscriberId":"435700022812","subscriberName":"LUSIA LEMA               ","subscriberSegmentation":"R1  ","swRefNumber":"0BNS256A4CC10E8311456487D74C6E63","switcherId":"0000000","tokenNumber":"12551044493256816844","totalAmount":"20000","totalRepeat":"0","traceNum":"000000000072","valueAddedTax":"0","vendingReceiptNumber":"00000000"},"responseCode":"00","responseMessage":"SUKSES","trxId":"000000000082"}';
        }
        return $response;
    }
    
    public static function plnnontaglist($jenis) {
        if($jenis == 'inq'){
            $response = '{"content":{"adminCharge":"0","areaCode":"12","customDetails":{"customDetailAmount":"0","customDetilCode":"01","minorUnitCustomDetail":"2"},"expirationDate":"07032017","minorUnitAdminCharge":"2","minorUnitPlnBill":"2","minorUnitTransactionAmount":"2","plnBillValue":"46920000","plnRefNumber":{},"registrationDate":"20170205","registrationNumber":"1221513003122 ","serviceUnit":"12215","serviceUnitAddress":"JL. PEMUDA NO 53 ","serviceUnitPhone":"123 ","subscriberId":"122150259115","subscriberName":"WAKIZAN ","switcherId":"0000000","switcherRefNumber":"AD88B9F8AD4D413B8980000000000000","totalAmount":"469200","totalRepeat":"1","transactionAmount":"46920000","transactionCode":"013","transactionName":"PERUBAHAN DAYA "},"responseCode":"00","responseMessage":"SUKSES","trxId":"000000000142"}';
        }else{
            $response = '{"content":{"infoText":"Informasi Hubungi Call Center 123 Atau Hub PLN Terdekat","adminCharge":"0","areaCode":"12","customDetails":{"customDetailAmount":"0","customDetilCode":"01","minorUnitCustomDetail":"2"},"expirationDate":"07032017","minorUnitAdminCharge":"2","minorUnitPlnBill":"2","minorUnitTransactionAmount":"2","plnBillValue":"46920000","plnRefNumber":{},"registrationDate":"20170205","registrationNumber":"1221513003122 ","serviceUnit":"12215","serviceUnitAddress":"JL. PEMUDA NO 53 ","serviceUnitPhone":"123 ","subscriberId":"122150259115","subscriberName":"WAKIZAN ","switcherId":"0000000","switcherRefNumber":"AD88B9F8AD4D413B8980000000000000","totalAmount":"469200","totalRepeat":"1","transactionAmount":"46920000","transactionCode":"013","transactionName":"PERUBAHAN DAYA "},"responseCode":"00","responseMessage":"SUKSES","trxId":"000000000142"}';
        }
        return $response;
    }
    
    public static function telkomtelepon($jenis) {
        if($jenis == 'inq'){
            $response = '{"content":{"jastelBills":{"@attributes":{"index":"1"},"bulanTag":"201803","nilaiTagihan":"55000","noRef":"803A       "},"jmlBill":"1","kodeArea":"0298","kodeDatel":"0001","kodeDivre":"04","namaPelanggan":" NGATMAN                      ","noTelp":"000313175","npwp":{"0":"               "},"totalAmount":"55000"},"responseCode":"00","responseMessage":"OK","trxId":"017680"}';
        }else{
            $response = '{"content":{"jastelBills":{"@attributes":{"index":"1"},"bulanTag":"201803","nilaiTagihan":"55000","noRef":"803A       "},"jmlBill":"1","kodeArea":"0298","kodeDatel":"0001","kodeDivre":"04","namaPelanggan":" NGATMAN                      ","noTelp":"000313175","npwp":{"0":"               "},"totalAmount":"55000"},"responseCode":"00","responseMessage":"OK","trxId":"017680"}';
        }
        return $response;
    }
    
    public static function telkomspeedy($jenis) {
        if($jenis == 'inq'){
            $response = '{"trxId":"110334","response_code":"0000","response_message":"OK","ket1":" donny alvaro                 ","tagihan":4080,"total_tagihan":4080,"lembar":1,"detail":{"jastelBills":{"@attributes":{"index":"1"},"bulanTag":"201711","nilaiTagihan":"4080","noRef":"711A       "},"jmlBill":"1","kodeArea":"0022","kodeDatel":"0006","kodeDivre":"03","namaPelanggan":" donny alvaro                 ","noTelp":"020270688","npwp":"              0"},"loadTime":"0.0004","tipe_request":"inquiry","prv":"hpay","userID":"1001010","idpel":"478566593424","product":"TELKOM","produk":"TELKOM","product_detail":"TELEPON","produk_tipe":"TELEPON","traceId":222132713918,"adm":2500}';
        }else{
            $response = '{"content":{"jastelBills":{"@attributes":{"index":"1"},"bulanTag":"201711","nilaiTagihan":"4080","noRef":"711A "},"jmlBill":"1","kodeArea":"0022","kodeDatel":"0006","kodeDivre":"03","namaPelanggan":" donny alvaro ","noTelp":"020270688"},"trxId":"110341","response_code":"0000","response_message":"OK","ket1":" donny alvaro ","tagihan":"4080","total_tagihan":410595,"detail":{"jastelBills":{"@attributes":{"index":"1"},"bulanTag":"201711","nilaiTagihan":"4080","noRef":"711A "},"jmlBill":"1","kodeArea":"0022","kodeDatel":"0006","kodeDivre":"03","namaPelanggan":" donny alvaro ","noTelp":"020270688"},"loadTime":"2.0043","tipe_request":"payment","prv":"hpay","userID":"1001010","idpel":"022-20270688","product":"TELKOM","produk":"TELKOM","product_detail":"TELEPON","produk_tipe":"TELEPON","traceId":222132713918,"amount":"4080","saldo":894149,"waktu":"2017-11-07 04:53:58","adm":2500}';
        }
        return $response;
    }
    
    public static function telkomvision($jenis) {
        if($jenis == 'inq'){
            $response = '';
        }else{
            $response = '';
        }
        return $response;
    }
    
    public static function telkomhalo($jenis) {
        if($jenis == 'inq'){
            $response = '';
        }else{
            $response = '';
        }
        return $response;
    }
    
    public static function bpjskesehatan($jenis) {
        if($jenis == 'inq'){
            $response = '{"content":{"billsInfo":[{"kodeCabang":"1107 ","namaCabang":"BOYOLALI                      ","namaPelanggan":"ARIF ARINTO                                       ","nomorPelanggan":"8888801432048217","saldo":"0","tagihanPremi":"80000"},{"kodeCabang":"1107 ","namaCabang":"BOYOLALI                      ","namaPelanggan":"monna marissa                                     ","nomorPelanggan":"8888801432049826","saldo":"0","tagihanPremi":"80000"},{"kodeCabang":"1107 ","namaCabang":"BOYOLALI                      ","namaPelanggan":"ahmad miza zaki                                   ","nomorPelanggan":"8888801432052662","saldo":"0","tagihanPremi":"80000"},{"kodeCabang":"1107 ","namaCabang":"BOYOLALI                      ","namaPelanggan":"AHMAD ZAIN AS SAFIY                               ","nomorPelanggan":"8888801432053729","saldo":"0","tagihanPremi":"80000"},{"kodeCabang":"1114 ","namaCabang":"UNGARAN                       ","namaPelanggan":"KINAR ALESHA NUR AZIZA                            ","nomorPelanggan":"8888802258645501","saldo":"0","tagihanPremi":"80000"},{"kodeCabang":{"0":"     "},"namaCabang":{"0":"                              "},"namaPelanggan":{"0":"                                                  "},"nomorPelanggan":{"0":"                "},"saldo":"0","tagihanPremi":"0"},{"kodeCabang":{"0":"     "},"namaCabang":{"0":"                              "},"namaPelanggan":{"0":"                                                  "},"nomorPelanggan":{"0":"                "},"saldo":"0","tagihanPremi":"0"}],"jmlBulan":"01","noReferensi":"1da15e7b09eb47d1b7efc989c9a6393f","noTelp":{"0":"               "},"nomorPelanggan":"8888001432048217","totalAmount":"400000","totalAnggota":"5","totalPremi":"400000","totalSaldo":"0"},"responseCode":"00","responseMessage":"OK","trxId":"271704"}';
        }else{
            $response = '{"content":{"billsInfo":[{"kodeCabang":"1107 ","namaCabang":"BOYOLALI                      ","namaPelanggan":"ARIF ARINTO                                       ","nomorPelanggan":"8888801432048217","saldo":"0","tagihanPremi":"80000"},{"kodeCabang":"1107 ","namaCabang":"BOYOLALI                      ","namaPelanggan":"monna marissa                                     ","nomorPelanggan":"8888801432049826","saldo":"0","tagihanPremi":"80000"},{"kodeCabang":"1107 ","namaCabang":"BOYOLALI                      ","namaPelanggan":"ahmad miza zaki                                   ","nomorPelanggan":"8888801432052662","saldo":"0","tagihanPremi":"80000"},{"kodeCabang":"1107 ","namaCabang":"BOYOLALI                      ","namaPelanggan":"AHMAD ZAIN AS SAFIY                               ","nomorPelanggan":"8888801432053729","saldo":"0","tagihanPremi":"80000"},{"kodeCabang":"1114 ","namaCabang":"UNGARAN                       ","namaPelanggan":"KINAR ALESHA NUR AZIZA                            ","nomorPelanggan":"8888802258645501","saldo":"0","tagihanPremi":"80000"},{"kodeCabang":{"0":"     "},"namaCabang":{"0":"                              "},"namaPelanggan":{"0":"                                                  "},"nomorPelanggan":{"0":"                "},"saldo":"0","tagihanPremi":"0"},{"kodeCabang":{"0":"     "},"namaCabang":{"0":"                              "},"namaPelanggan":{"0":"                                                  "},"nomorPelanggan":{"0":"                "},"saldo":"0","tagihanPremi":"0"}],"idTransaksi":"6a01222c94824abda68176ed3fe6d771","jmlBulan":"01","noReferensi":"1f7b3e4ecec14fc18df939c29e949461","noTelp":{"0":"               "},"nomorPelanggan":"8888001432048217","totalAmount":"400000","totalAnggota":"5","totalPremi":"400000","totalSaldo":"0"},"responseCode":"00","responseMessage":"OK","trxId":"284422"}';
        }
        return $response;
    }

}
