<!DOCTYPE html>
<html>

<head>
    <title>gondangria.com</title>
</head>

<body>
    <div style="width:600px;margin:0 auto;background-color:white">
        <div style="margin-top:10px;text-align:center;width:100%;">
            <img style="width:80%;" src="https://res.cloudinary.com/dg0u92jif/image/upload/v1702468120/Ticket_gondang_ria_ssrdpq.png"
                class="CToWUd" data-bit="iit">
        </div>
        <div style="margin-top:20px;border-top:solid 5px #398EC7">
            <h3 style="color:black;">Hi {{ $mailData['nama']}},</h3>
            <p style="color:black;">Email ini mengkonfirmasi bahwa anda telah membeli tiket Gondang Ria Waterpark.</p>

            <hr style="border:1px dashed #398EC7;color:#fff;background-color:#fff">

            <p></p>
            <h3>Detail pembayarann</h3>
            <p></p>
            <table style="margin-left:20px;font-size:14px">
                <tbody>
                    <tr>
                        <td>Id pembelian</td>
                        <td><span style="margin:0 20px">:</span>{{ $mailData['order_id'] }}</td>
                    </tr>
                    <tr>
                        <td>Jumlah tiket</td>
                        <td><span style="margin:0 20px">:</span>{{ $mailData['jumlah_tiket'] }}</td>
                    </tr>
                    <tr>
                        <td>Subtotal</td>
                        <td><span style="margin:0 20px">:</span>Rp. {{ $mailData['subtotal'] }},-</td>
                    </tr>
                    <tr>
                        <td>Nama</td>
                        <td><span style="margin:0 20px">:</span>{{ $mailData['nama'] }}</td>
                    </tr>
                    <tr>
                        <td>Tanggal</td>
                        <td><span style="margin:0 20px">:</span>{{ $mailData['tanggal'] }}</td>
                    </tr>
                </tbody>
            </table>
            <hr style="border:1px dashed #398EC7;color:#fff;background-color:#fff">


            <div style="font-size:12px">
                <p>Terima kasih</p>
                <p></p>
                <p style="font-size:14px"><strong>Gondang Ria Waterpark</strong></p>
            </div>
        </div>
        <img src="https://ci3.googleusercontent.com/meips/ADKq_NZfyWTM0nC2GxgyrzQTlFnoIFs444L2hVqgfX9xDW_PIMLE4PjCvdwr_5honheR1VmIbFYe2yjHY9nFNRUfs5iBLYh6l6tNWN5nmDlH1CjqNUvIrINmxtld9fnhDRSGxuSfAk3O-LBSrzOp0SHEfoq356u4VymYdSecBiCr8eNse-zYqFR399mknM2YiWqQdfqEmQo8gjmXSi9z2k7p3mqLDaJRg4Dkxfp3PWWS2f5B-x07ET2hi9m4ozHTP3TubrCm5UZJpRQXc9JnQwBRAF4zfH3abcDiSSdg0sTqo2Ed4CvJ12JWLYZ2D0DqEq9MYePZvD3e_5JKyodbbdKZ6GUqmp-woB7Z2T9-PpOrjoQ5IYjZGh7BIRUsTo2a1PQ6gKghkclSHyiqlC7sK38f2jPEcblpxw=s0-d-e1-ft#http://url3404.cgv.id/wf/open?upn=42UPGXk2x6ucwZAjb3gvKMZB9Mrhw32bh8X6U5Oz-2FOf3M0DgFeXjheZ37nEUjrbKTipMI1JlZf-2BwJcBV9MeRvStkzT52YUlXWKsJDC0D9YgP4vCZB-2FUF3CPr-2B-2FERgAnuktbdriLe0lJl2-2FlZidi5yxGUuVmVEsBBDqNtynacJ1me5kKoXGuHVnohc6NKpCfFarLIRFZK9zn1qqzfYFbGf1I-2FhHPrJAuyvNX13bl4v24-3D"
            alt="" width="1" height="1" border="0"
            style="height:1px!important;width:1px!important;border-width:0!important;margin-top:0!important;margin-bottom:0!important;margin-right:0!important;margin-left:0!important;padding-top:0!important;padding-bottom:0!important;padding-right:0!important;padding-left:0!important"
            class="CToWUd" data-bit="iit">
    </div>

</body>

</html>