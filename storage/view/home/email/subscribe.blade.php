<div>
    <includetail>
        <table border="0" cellpadding="0" cellspacing="0" style="width: 600px; border: 1px solid #ddd; border-radius: 3px; color: #555; font-family: 'Helvetica Neue Regular',Helvetica,Arial,Tahoma,'Microsoft YaHei','San Francisco','微软雅黑','Hiragino Sans GB',STHeitiSC-Light; font-size: 12px; height: auto; margin: auto; overflow: hidden; text-align: left; word-break: break-all; word-wrap: break-word;">
            <tbody style="margin: 0; padding: 0;">
            <tr style="background-color: #393D49; height: 60px; margin: 0; padding: 0;">
                <td style="margin: 0; padding: 0;"><div style="color: #5EB576; margin: 0; margin-left: 30px; padding: 0;"><a style="font-size: 14px; margin: 0; padding: 0; color: #5EB576; text-decoration: none;" href="https://www.zongscan.com/" target="_blank">www.zongscan.com - 订阅推送邮件</a></div></td>
            </tr>
            <tr style="margin: 0; padding: 0;">
                <td style="margin: 0; padding: 30px;">
                    <p style="line-height: 20px; margin: 0; margin-bottom: 10px; padding: 0;">Hi，<em style="font-weight: 700;">你好</em>，本次推送上周最热文章1篇</p>
                    <div><a href="https://www.zongscan.com/demo333/{{$art[0]['art_id']}}" style="background-color: #66CCCC; color: #fff; display: inline-block; height: 32px; line-height: 32px; margin: 0 15px 0 0; padding: 0 15px; text-decoration: none;" target="_blank">{{$art[0]['title']}}</a></div>
                    <p> {{mb_substr(strip_tags($art[0]['content']),0,200)}}...</p>
                    <a href="https://www.zongscan.com/demo333/{{$art[0]['art_id']}}.html" style="float: right;">------>>>查看全文</a>
                </td>
            </tr>
            <tr style="background-color: #fafafa; color: #999; height: 35px; margin: 0; padding: 0; text-align: center;"><td style="margin: 0; padding: 0;">系统邮件，请勿直接回复。</td></tr>
            </tbody>
        </table>
    </includetail>
</div>