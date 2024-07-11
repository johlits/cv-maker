docker build -t cv-maker .

docker run -v $(pwd):/app cv-maker
