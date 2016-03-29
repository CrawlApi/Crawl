# Crawl

### About

1. **What is it?**
This is PHP code for many crawl api.

## Install

1. git clone [https://github.com/code-h/Crawl](https://github.com/code-h/Crawl)
2. composer install
3. app/config doctrine:schema:update --dump-sql --force

### Requests
|           Type               |                                    URL                                           |
|------------------------------|----------------------------------------------------------------------------------|
|        **Supported**         |                                                                                  |
| GetWord                      | http://apimarket.xyz/api/word/{word}                                             |
| GetRestaurants               | http://apimarket.xyz/api/takeout/{place}                                         |
| GetFoodsByRestaurants        | http://apimarket.xyz/api/takeout/{place}/{restaurant}                            |

## License

The Project is released under the [MIT License](LICENSE).