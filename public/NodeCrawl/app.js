// app.js
const puppeteer = require("puppeteer");

(async () => {
    // Lấy URL từ tham số dòng lệnh
    const url = process.argv[2];

    if (!url) {
        console.error('Please provide a URL as a command line argument');
        return;
    }

    const browser = await puppeteer.launch();
    const page = await browser.newPage();
    await page.goto(url);

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
                return 0 + '_' + 0;
            }
        }
    });

    console.log(src);

    await browser.close();
    res.json({ link: link, source: src });
})();
