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
            const src = iframe.src;
            const url = new URL(src);
            return url.searchParams.get("link");
        } else {
            return null;
        }
    });

    console.log(src);

    await browser.close();
})();
