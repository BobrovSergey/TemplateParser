<?php

namespace TemplateParser;


class Parser
{

    /**
     * @var string
     */
    public $openingTag = '{{';

    /**
     * @var string
     */
    public $closingTag = '}}';

    /**
     * @var string
     */
    public $currentDate = 'currentDate';

    /**
     * @var string
     */
    public $dateFormat = 'Y-m-d';

    /**
     * @var string
     */
    private $template;

    /**
     * @var array
     */
    public $parametersSet = [];

    /**
     * Constructor.
     * @param string $template
     */
    public function __construct($template = '')
    {
        $this->template = $template;
    }


    /**
     * Fill parameter's set array
     * @param $name
     * @param $value
     * @return Parser
     */
    public function __call($name, $value)
    {
        $name = lcfirst(str_replace('set', '', $name));
        $this->parametersSet[$name] = implode(', ', $value);
        return $this;
    }

    /**
     * Parse template
     * @return string
     */
    public function parseTemplate()
    {
        try {

            $data = $this->parametersSet;
            $dateFormat = $this->dateFormat;
            $currentDate = $this->currentDate;

            $result = preg_replace_callback('/' . $this->openingTag . '(\w+)' . $this->closingTag . '/',
                function ($match) use ($data, $dateFormat, $currentDate) {

                    //set current date
                    if ($match[1] == $currentDate) {
                        $data[$currentDate] = date($dateFormat);
                    }
                    if (!isset($data[$match[1]])) {
                        throw new \Exception('You should set ' . $match[1] . '!');
                    }
                    return $data[$match[1]];
                }, $this->template);

        } catch (\Exception $e) {
            echo $e->getMessage();
            exit;
        }

        return $result;
    }
}