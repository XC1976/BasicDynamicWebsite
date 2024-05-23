#type the following line into mysql first
sudo mariadb -e "drop database if exists openreads; create database openreads; use openreads;"
echo 'openreads.sql'
sudo mariadb openreads < sql_scripts/openreads.sql
if [ $? -eq 0 ]; then 
    echo ' : success'
else 
    echo ' : failed'
    exit 1
fi

echo 'insert_users.sql'
sudo mariadb openreads < sql_scripts/insert_users.sql
if [ $? -eq 0 ]; then 
    echo ' : success'
else 
    echo ' : failed'
    exit 1
fi

echo 'insert_newletter.sql'
sudo mariadb openreads < sql_scripts/insert_newletter.sql
if [ $? -eq 0 ]; then 
    echo ' : success'
else 
    echo ' : failed'
    exit 1
fi

echo 'captchaQuestions.sql'
sudo mariadb openreads < sql_scripts/captchaQuestions.sql
if [ $? -eq 0 ]; then 
    echo ' : success'
else 
    echo ' : failed'
    exit 1
fi

echo 'insert_categories.sql'
sudo mariadb openreads < sql_scripts/insert_categories.sql
if [ $? -eq 0 ]; then 
    echo ' : success'
else 
    echo ' : failed'
    exit 1
fi

echo 'insert_discussion.sql'
sudo mariadb openreads < sql_scripts/insert_discussion.sql
if [ $? -eq 0 ]; then 
    echo ' : success'
else 
    echo ' : failed'
    exit 1
fi

echo 'insert_post.sql'
sudo mariadb openreads < sql_scripts/insert_post.sql
if [ $? -eq 0 ]; then 
    echo ' : success'
else 
    echo ' : failed'
    exit 1
fi

echo 'insert_genre.sql'
sudo mariadb openreads < sql_scripts/insert_genre.sql
if [ $? -eq 0 ]; then 
    echo ' : success'
else 
    echo ' : failed'
    exit 1
fi

echo 'insert_authors.sql'
sudo mariadb openreads < sql_scripts/insert_authors.sql
if [ $? -eq 0 ]; then 
    echo ' : success'
else 
    echo ' : failed'
    exit 1
fi

echo 'insert_books.sql'
sudo mariadb openreads < sql_scripts/insert_books.sql
if [ $? -eq 0 ]; then 
    echo ' : success'
else 
    echo ' : failed'
    exit 1
fi

echo 'insert_booksMarketplace.sql'
sudo mariadb openreads < sql_scripts/insert_booksMarketplace.sql
if [ $? -eq 0 ]; then 
    echo ' : success'
else 
    echo ' : failed'
    exit 1
fi

echo 'insert_reviews.sql'
sudo mariadb openreads < sql_scripts/insert_reviews.sql
if [ $? -eq 0 ]; then 
    echo ' : success'
else 
    echo ' : failed'
    exit 1
fi

echo 'insert_reports.sql'
sudo mariadb openreads < sql_scripts/insert_reports.sql
if [ $? -eq 0 ]; then 
    echo ' : success'
else 
    echo ' : failed'
    exit 1
fi

echo 'insert_challenge.sql'
sudo mariadb openreads < sql_scripts/insert_challenge.sql
if [ $? -eq 0 ]; then 
    echo ' : success'
else 
    echo ' : failed'
    exit 1
fi
