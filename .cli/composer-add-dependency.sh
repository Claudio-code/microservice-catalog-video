echo "add your dependency name"
read dependencyName

docker exec -it micro-videos-app bash -c  "composer require ${dependencyName}"
