docker build -t cv-maker .

docker run -d -p 8080:80 -v "$(pwd):/var/www/html" cv-maker

