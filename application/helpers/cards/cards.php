<?php
class Carteirinha {

    private $img;
    private $largura;
    private $altura;
    private $transparencia;
    private $imagem_carteira;
    private $foto;
    private $nome_aluno;
    private $red, $green, $blue, $cor_texto;
    private $expessura_fonte, $esquerda, $topo;
    private $f_esquerda, $f_topo, $f_largura, $f_altura;

    public function __construct($largura, $altura) {
        $this->largura = $largura;
        $this->altura = $altura;
        $this->img = imagecreatetruecolor($largura, $altura);
        imagesavealpha($this->img, true);
        $this->transparencia = imagecolorallocatealpha($this->img, 0, 0, 0, 100);
        imagefill($this->img, 0, 0, $this->transparencia);
    }

    public function setImagemCarteira($imagem) {
        $this->imagem_carteira = imagecreatefromjpeg($imagem);
    }

    public function setFoto($imagem) {
        $this->foto = imagecreatefromjpeg($imagem);
    }

    public function setNomeAluno($nome_aluno) {
        $this->nome_aluno = $nome_aluno;
    }

    public function setCorTexto($red, $green, $blue) {
        $this->red = $red;
        $this->green = $green;
        $this->blue = $blue;

        $this->cor_texto = imagecolorallocate($this->img, $red, $green, $blue);
    }

    public function setTexto($expessura_fonte, $esquerda, $topo) {
        $this->expessura_fonte = $expessura_fonte;
        $this->esquerda = $esquerda;
        $this->topo = $topo;
    }

    public function setTamanhoFoto($esquerda, $topo, $altura, $largura) {
        $this->f_esquerda = $esquerda;
        $this->f_topo = $topo;
        $this->f_altura = $altura;
        $this->f_largura = $largura;
    }

    public function gerar($nome_da_carteira) {
        imagecopy($this->img, $this->imagem_carteira, 0, 0, 0, 0, $this->largura, $this->altura);
        imagecopy($this->img, $this->foto, $this->f_esquerda, $this->f_topo, 0, 0, $this->f_largura, $this->f_altura);

        imagestring($this->img, $this->expessura_fonte, $this->esquerda, $this->topo, $this->nome_aluno, $this->cor_texto);

        header("Content-type: image/jpg");
        imagejpeg($this->img);
        imagejpeg($this->img, "{$nome_da_carteira}.jpg", 100);
        imagedestroy($this->img);
    }

}