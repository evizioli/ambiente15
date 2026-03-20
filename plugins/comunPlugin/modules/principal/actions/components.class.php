<?php 

class principalComponents extends sfComponents
{
    public function executeEsquemaStylesheets()
    {
        $this->esquemas=EsquemaQuery::create()->filterByArchivo(null, Criteria::ISNOTNULL)->find();
    }
}