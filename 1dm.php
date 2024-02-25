import requests

def fetch_resource(vid):
    base_url = 'https://lakshyajee.github.io/node_modules/1dm.php?vid='
    url = base_url + vid

    headers = {
        'User-Agent': 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/121.0.0.0 Safari/537.36',
        'Referer': 'https://lakshyajee.github.io/',
        'Origin': 'https://lakshyajee.github.io',
        'Sec-Fetch-Dest': 'empty',
        'Sec-Fetch-Mode': 'cors',
        'Sec-Fetch-Site': 'cross-site',
        'Sec-Fetch-User': '?1',
        'Accept': '*/*',
    }

    try:
        response = requests.get(url, headers=headers)
        response.raise_for_status()  # Raise an exception for HTTP errors

        # Print response headers
        print("Response Headers:")
        for header, value in response.headers.items():
            print(f"{header}: {value}")

        # Print response content
        print("Response Content:")
        print(response.text)
    except requests.exceptions.RequestException as e:
        print(f"Error: {e}")

if __name__ == "__main__":
    vid = input("Enter vid ID: ")
    fetch_resource(vid)
