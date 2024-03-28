const express = require('express');
const puppeteer = require("puppeteer");
const app = express();
const port = 80;

app.get('/', function (req, res) {
    res.send("Hello 80");
});

app.get('/crawl', async (req, res, next, puppeteer) => {

    try {
        const link = req.query.p; // Lấy giá trị của tham số 'p' từ query parameter
        if (!link) {
            return res.status(400).send('Missing query parameter "p"');
        }
        const browser = await puppeteer.launch(); // Khởi động trình duyệt
        const page = await browser.newPage(); // Tạo trang mới
        await page.goto(link); // Điều hướng đến URL được chỉ định

        const src = await page.evaluate(() => {
            const iframe = document.querySelector("iframe.metaframe");
            if (iframe) {
                const iframeSRC = iframe.src;
                const startIndex = iframeSRC.indexOf('=') + 1; // Tìm vị trí bắt đầu của phần link
                const src = iframeSRC.slice(startIndex);
                const type = 'iframe';
                return type + '_' + src;
            } else {
                const video = document.querySelector("video");
                if (video) {
                    const src = video.src;
                    const type = 'video';
                    return type + '_' + src;
                } else {
                    return '0_0';
                }
            }
        });

        console.log(src);

        await browser.close(); // Đóng trình duyệt sau khi hoàn thành

        res.json({ link: link, source: src });
    } catch (error) {
        console.error(error);
        res.status(500).send(error);
    }
});

app.listen(port, function (error) {
    if (error) {
        console.log("Saiport");
    }
    console.log("server is running port: " + port);
});
