const express = require('express');
const cors = require('cors');
const app = express();

// Use CORS middleware to allow requests from any origin
app.use(cors());

app.get('/getVideo', (req, res) => {
    const { lectureKey } = req.query;
    const cloudFrontURL = `https://d1d34p8vz63oiq.cloudfront.net/${lectureKey}/master.mpd`;
    
    // Fetch the video from CloudFront (or use any other method to retrieve the video)
    fetch(cloudFrontURL)
        .then(response => {
            // Forward the response from CloudFront to the client with CORS headers
            res.setHeader('Access-Control-Allow-Origin', '*');
            res.setHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
            res.setHeader('Access-Control-Allow-Headers', 'Content-Type, Authorization');
            response.body.pipe(res);
        })
        .catch(error => {
            console.error('Error fetching video:', error);
            res.status(500).send('Internal Server Error');
        });
});

const PORT = process.env.PORT || 3000;
app.listen(PORT, () => {
    console.log(`Server is running on port ${PORT}`);
});
