<?php

namespace Iagen\MaGPT\Controller\Adminhtml\Get;

use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Controller\Result\JsonFactory;

class Retrieve extends \Magento\Backend\App\Action
{
    /**
     * @var RequestInterface
     */
    protected $request;

    protected $scopeConfig;

    /**
     * @var JsonFactory
     */
    protected $resultJsonFactory;

    /**
     * @param Context $context
     * @param RequestInterface $request
     * @param JsonFactory $resultJsonFactory
     */
    public function __construct(
        Context $context,
        RequestInterface $request,
        JsonFactory $resultJsonFactory,
        ScopeConfigInterface $scopeConfig,
    ) {
        parent::__construct($context);
        $this->request = $request;
        $this->scopeConfig = $scopeConfig;
        $this->resultJsonFactory = $resultJsonFactory;
    }

    /**
     * Execute action based on request and return result
     *
     * @return \Magento\Framework\Controller\ResultInterface|void
     */
    public function execute()
    {
        
        if ($this->scopeConfig->getValue('gpt/gptconfig/gptstatus')) {
            
            $apiKey = $this->scopeConfig->getValue('gpt/gptconfig/gptkey');
            $productName = $this->getRequest()->getParam('product_name');
            $metaTitle = $this->getRequest()->getParam('meta_title');
            $metaKeyword = $this->getRequest()->getParam('meta_keyword');
            $metaDescription = $this->getRequest()->getParam('meta_description');

            $productPrompt = $this->scopeConfig->getValue('gpt_prompt_section/gpt_prompt/gpt_prompt_product'); // prompt

            // muda o prompt definido no back-end
            $productPrompt = str_replace('$product_name', ($productName ? $productName : ''), $productPrompt);
            $productPrompt = str_replace('$meta_title', ($metaTitle ? $metaTitle : ''), $productPrompt);
            $productPrompt = str_replace('$meta_keyword', ($metaKeyword ? $metaKeyword : ''), $productPrompt);
            $productPrompt = str_replace('$meta_description', ($metaDescription ? $metaDescription : ''), $productPrompt);
            //

            $result_gpt = json_decode($this->getChatCompletion($apiKey,"gpt-3.5-turbo", "user", $productPrompt ));
            
            $result = $this->resultJsonFactory->create();

            return $result->setData($result_gpt);
        }
    }

    public function getChatCompletion($apiKey, $model, $role, $messageContent) { // future use in helper
        // Inicia a conexão cURL
        $ch = curl_init();
        
        // Define as opções da requisição HTTP
        curl_setopt_array($ch, [
            CURLOPT_URL => 'https://api.openai.com/v1/chat/completions',
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_POST => 1,
            CURLOPT_POSTFIELDS => json_encode([
                'model' => $model, // Nome do modelo treinado na OpenAI [gpt-3.5-turbo]
                'messages' => [
                    [
                        'role' => $role, // Papel do autor da mensagem
                        'content' => $messageContent, // Conteúdo da mensagem
                    ],
                ],
            ]),
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json',
                'Authorization: Bearer ' . $apiKey, // Chave de autenticação da OpenAI
            ],
        ]);
    
        // Executa a requisição e armazena o resultado em uma variável
        $result = curl_exec($ch);
    
        // Verifica se ocorreu algum erro durante a requisição HTTP
        if (curl_errno($ch)) {
            throw new \Exception('Failed to get response from OpenAI: ' . curl_error($ch));
        }
    
        // Fecha a conexão cURL
        curl_close($ch);
    
        // Decodifica o resultado da requisição para um array associativo
        $resultado = json_decode($result, true);
    
        // Verifica se a resposta da API é válida e contém uma mensagem de resposta
        if (is_null($resultado) || !isset($resultado['choices'][0]['message']['content'])) {
            throw new \Exception('Failed to parse response from OpenAI');
        }
    
        // Retorna o conteúdo da mensagem de resposta gerada pela OpenAI
        return $resultado['choices'][0]['message']['content'];
    }
    
    


}
