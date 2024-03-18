const express = require('express');
const cors = require('cors');
const fetch = require('node-fetch'); // Import fetch module
const app = express();

// Use CORS middleware to allow requests from any origin
app.use(cors());

app.get('/getVideo', async (req, res) => {
    const { lectureKey } = req.query;
    const cloudFrontURL = `https://d1d34p8vz63oiq.cloudfront.net/${lectureKey}/master.mpd`;
    
    try {
        // Fetch the video from CloudFront
        const response = await fetch(cloudFrontURL);

        // Check if the request was successful
        if (!response.ok) {
            throw new Error('Failed to fetch video');
        }

        // Set CORS headers
        res.setHeader('Access-Control-Allow-Origin', '*');
        res.setHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
        res.setHeader('Access-Control-Allow-Headers', 'Content-Type, Authorization');

        // Pipe the response body to the client
        response.body.pipe(res);
    } catch (error) {
        console.error('Error fetching video:', error);
        res.status(500).send('Internal Server Error');
    }
});

const PORT = process.env.PORT || 3000;
app.listen(PORT, () => {
    console.log(`Server is running on port ${PORT}`);
});
