ThinkPHP 6.0
===============

> 运行环境要求PHP8,redis5,mysql >= 5.7

## 安装
~~~
git clone https://github.com/L-zhicong/BlogApi.git

cd BlogApi

composer install

php think run 
~~~

## docker 构建
```
cd BlogApi && docker build -t blog:v1 .
```

##docker 安装
你可以写docker-compose
也可以直接run
```
docker run blog:v1 -p 8888:8888 -v /data/www/BlogApi/config:/data/www/BlogApi/config
```


##k8s 安装
将刚才构建到镜像push到你到私人仓库
```
cd k8s

kubectl apply -f blogapi-rs
```



