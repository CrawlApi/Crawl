# Crawl

### About

1. **What is it?**
This is PHP code for Crawl Api.

## Install

1. git clone [https://github.com/CrawlApi/Crawl](https://github.com/CrawlApi/Crawl)
2. composer install
3. app/config doctrine:schema:update --dump-sql --force

## Requests

| API | GetWord |
| --- | --------- |
| url | http://apimarket.xyz/api/word/ `查询的单词` |
| method | GET |
| response | JSON |

错误返回（JSON）
```
  {
    errCode: 500
    errMsg: 服务器请求失败
  }
```
```
  {
    errCode: 404
    errMsg: 单词不存在
  }
```

| API | GetRestaurants |
| --- | --------- |
| url | http://apimarket.xyz/api/word/ `地理位置` |
| method | GET |
| response | JSON |

| API | GetFoodsByRestaurants |
| --- | --------- |
| url | http://apimarket.xyz/api/word/ `地理位置` / `店铺id` |
| method | GET |
| response | JSON |

## Todo

P.S. 需要新增Api可以在[issue #1](https://github.com/CrawlApi/Crawl/issues/1)下留言

## License

The Project is released under the [MIT License](LICENSE).
