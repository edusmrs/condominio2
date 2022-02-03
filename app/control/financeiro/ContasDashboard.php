<?php

use Adianti\Control\TPage;
use Adianti\Database\TTransaction;
use Adianti\Widget\Base\TElement;
use Adianti\Widget\Container\TVBox;
use Adianti\Widget\Template\THtmlRenderer;

class ContasDashboard extends TPage{
    function __construct()
    {
        parent::__construct();

        $vbox = new TVBox;
        $vbox->style = 'width> 100k';

        $div = new TElement('div');
        $div->class = "row";

        try
        {
            TTransaction::open('db_condominio');

            $valor = ContaPagar::where('valor','>', 0)->sumBy('valor');
            $valor_pago = ContaPagar::where('valor_pago','>', 0)->sumBy('valor_pago');
            $juros = ContaPagar::where('saldo','>', 0)->sumBy('saldo');

            $valor_receber = ContaReceber::where('valor','>',0)->sumBy('valor');
            $valor_recebido = ContaReceber::where('valor_recebido','>',0)->sumBy('valor_recebido');
            $juros_recebido = ContaReceber::where('juros_recebido','>',0)->sumBy('juros_recebido');

            TTransaction::close();

            $indicator1 = new THtmlRenderer('app/resources/info-box.html');
            $indicator2 = new THtmlRenderer('app/resources/info-box.html');
            $indicator3 = new THtmlRenderer('app/resources/info-box.html');
            $indicator4 = new THtmlRenderer('app/resources/info-box.html');
            $indicator5 = new THtmlRenderer('app/resources/info-box.html');
            $indicator6 = new THtmlRenderer('app/resources/info-box.html');

            $indicator1->enableSection('main',['title'=>'VALOR A PAGAR','icon'=>'money-bill','background'=>'blue','value'=>'R$ '.number_format($valor,2,',','.')]);
            $indicator2->enableSection('main',['title'=>'TOTAL A PAGAR','icon'=>'money-bill','background'=>'green','value'=>'R$ '.number_format($valor_pago,2,',','.')]);
            $indicator3->enableSection('main',['title'=>'JUROS','icon'=>'money-bill','background'=>'orange','value'=>'R$ '.number_format($juros,2,',','.')]);
            $indicator4->enableSection('main',['title'=>'VALOR A RECEBER','icon'=>'money-bill','background'=>'red','value'=>'R$ '.number_format($valor_receber,2,',','.')]);      
            $indicator5->enableSection('main',['title'=>'VALOR RECEBIDO','icon'=>'money-bill','background'=>'pink','value'=>'R$ '.number_format($valor_recebido,2,',','.')]);
            $indicator6->enableSection('main',['title'=>'JUROS RECEBIDO','icon'=>'money-bill','background'=>'orange','value'=>'R$ '.number_format($juros_recebido,2,',','.')]);
        
            $div->add(TElement::tag('div',$indicator1,['class'=>'col-se-6']));
            $div->add(TElement::tag('div',$indicator2,['class'=>'col-se-6']));
            $div->add(TElement::tag('div',$indicator3,['class'=>'col-se-6']));
            $div->add(TElement::tag('div',$indicator4,['class'=>'col-se-6']));
            $div->add(TElement::tag('div',$indicator5,['class'=>'col-se-6']));
            $div->add(TElement::tag('div',$indicator6,['class'=>'col-se-6']));
        }

    }
}

