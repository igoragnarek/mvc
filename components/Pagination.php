<?php

class Pagination
{

    private $max = 10;

    private $index;

    private $current_page;

    private $total;

    private $limit;

    private $amount;

    public function __construct( int $total, int $currentPage, int $limit, string $index)
    {
        $this->total = $total;
        $this->limit = $limit;
        $this->index = $index;
        $this->current_page = $currentPage;

        $this->amount = $this->amount();
        
        
    }

    public function get()
    {

        $links = null;
        $limits = $this->limits();
        
        $html = '<ul class="pagination">';

        for ($page = $limits[0]; $page <= $limits[1]; $page++) {

            if ($page == $this->current_page) {
                $links .= '<li class="active"><a href="#">' . $page . '</a></li>';
            } else {

                $links .= $this->generateHtml($page);
            }
        }

        if (!is_null($links)) {
            # Если текущая страница не первая
            if ($this->current_page > 1)
            # Создаём ссылку "На первую"
                $links = $this->generateHtml(1, '&lt;') . $links;

            # Если текущая страница не последняя
            if ($this->current_page < $this->amount)
            # Создаём ссылку "На последнюю"
                $links .= $this->generateHtml($this->amount, '&gt;');
        }

        $html .= $links . '</ul>';

        return $html;
    }

    private function generateHtml($page, $text = null)
    {
        
        if (!$text){
            $text = $page;
        }

        $currentURI = rtrim($_SERVER['REQUEST_URI'], '/') . '/';
        $currentURI = preg_replace('~/page-[0-9]+~', '', $currentURI);

        return
                '<li><a href="' . $currentURI . $this->index . $page . '">' . $text . '</a></li>';
          
    }


     // return массив с началом и концом отсчёта

    private function limits()
    {
        // Вычисляем ссылки слева (чтобы активная ссылка была посередине)
        $left = $this->current_page - round($this->max / 2); 
        
        # Вычисляем начало отсчёта
        $start = $left > 0 ? $left : 1; 

        # Если впереди есть как минимум $this->max страниц
        if ($start + $this->max <= $this->amount) { 
        # Назначаем конец цикла вперёд на $this->max страниц или просто на минимум
            $end = $start > 1 ? $start + $this->max : $this->max;
        } else {

            $end = $this->amount;

            # Начало - минус $this->max от конца
            $start = $this->amount - $this->max > 0 ? $this->amount - $this->max : 1;
        }

        return
                array($start, $end);
    }


    // Для получения общего числа страниц
    private function amount()
    {
        return ceil($this->total / $this->limit);
    }

}
