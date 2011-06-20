<?php

class ComRapleafControllerToolbarDashboard extends ComDefaultControllerToolbarDefault
{
    public function __construct(KConfig $config)
    {
        parent::__construct($config);
       
		var_dump($this->getTitle());
        $this->reset()
			->setTitle('tests');
    }
}