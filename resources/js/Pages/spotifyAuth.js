import axios from "axios";

async function getSpotifyAccessToken() {
    try {
        const response = await axios.get('/spotify-token');
        return response.data.access_token;
    } catch (error) {
        console.error("Error fetching Spotify access token", {
            message: error.message,
            response: error.response ? error.response.data : null,
        });
        return null;
    }
}

export { getSpotifyAccessToken };
