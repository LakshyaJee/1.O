const http = require('http');
const https = require('https');
const url = require('url');

const server = http.createServer((req, res) => {
    const queryObject = url.parse(req.url, true).query;
    const lectureCode = queryObject.lectureCode; // Assuming 'lectureCode' is the parameter name

    // Construct the MPD URL using the lectureCode
    const mpdUrl = `https://d1d34p8vz63oiq.cloudfront.net/${lectureCode}/master.mpd`;

    // Fetch the MPD file
    https.get(mpdUrl, (response) => {
        // Set CORS headers
        res.setHeader('Access-Control-Allow-Origin', '*');
        // Pipe the response to the client
        response.pipe(res);
    }).on('error', (error) => {
        console.error('Error fetching MPD file:', error);
        res.statusCode = 500;
        res.end('Error fetching MPD file');
    });
});

const PORT = process.env.PORT || 3000;
server.listen(PORT, () => {
    console.log(`Server listening on port ${PORT}`);
});
