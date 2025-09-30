#!/usr/bin/env python3
"""
Script para criar imagens placeholder para o site LL Magazine
"""

from PIL import Image, ImageDraw, ImageFont
import os

def create_hero_image(filename, title, color1, color2):
    """Cria imagem do hero banner"""
    width, height = 400, 600
    img = Image.new('RGB', (width, height), color1)
    draw = ImageDraw.Draw(img)
    
    # Gradiente simples
    for y in range(height):
        ratio = y / height
        r = int(color1[0] * (1 - ratio) + color2[0] * ratio)
        g = int(color1[1] * (1 - ratio) + color2[1] * ratio)
        b = int(color1[2] * (1 - ratio) + color2[2] * ratio)
        draw.line([(0, y), (width, y)], fill=(r, g, b))
    
    # Círculo para cabeça
    draw.ellipse([150, 100, 250, 200], fill=(255, 255, 255, 180))
    
    # Retângulo para corpo
    draw.rectangle([150, 200, 250, 350], fill=(255, 255, 255, 180))
    
    # Texto
    try:
        font = ImageFont.truetype("/usr/share/fonts/truetype/dejavu/DejaVuSans-Bold.ttf", 24)
        font_small = ImageFont.truetype("/usr/share/fonts/truetype/dejavu/DejaVuSans.ttf", 14)
    except:
        font = ImageFont.load_default()
        font_small = ImageFont.load_default()
    
    # Título
    bbox = draw.textbbox((0, 0), title, font=font)
    text_width = bbox[2] - bbox[0]
    draw.text(((width - text_width) // 2, 50), title, fill=(255, 255, 255), font=font)
    
    # Subtítulo
    subtitle = "LL Magazine"
    bbox = draw.textbbox((0, 0), subtitle, font=font_small)
    text_width = bbox[2] - bbox[0]
    draw.text(((width - text_width) // 2, 80), subtitle, fill=(255, 255, 255), font=font_small)
    
    img.save(filename, 'JPEG', quality=85)

def create_product_image(filename, product_name, bg_color):
    """Cria imagem de produto"""
    width, height = 300, 300
    img = Image.new('RGB', (width, height), bg_color)
    draw = ImageDraw.Draw(img)
    
    # Círculo para cabeça
    draw.ellipse([120, 80, 180, 140], fill=(255, 255, 255, 180))
    
    # Retângulo para corpo
    draw.rectangle([120, 140, 180, 220], fill=(255, 255, 255, 180))
    
    # Texto do produto
    try:
        font = ImageFont.truetype("/usr/share/fonts/truetype/dejavu/DejaVuSans-Bold.ttf", 16)
    except:
        font = ImageFont.load_default()
    
    # Quebrar texto se muito longo
    words = product_name.split()
    lines = []
    current_line = []
    
    for word in words:
        current_line.append(word)
        test_line = ' '.join(current_line)
        bbox = draw.textbbox((0, 0), test_line, font=font)
        if bbox[2] - bbox[0] > width - 40:
            if len(current_line) > 1:
                current_line.pop()
                lines.append(' '.join(current_line))
                current_line = [word]
            else:
                lines.append(word)
                current_line = []
    
    if current_line:
        lines.append(' '.join(current_line))
    
    # Desenhar linhas de texto
    y_start = 250
    for i, line in enumerate(lines):
        bbox = draw.textbbox((0, 0), line, font=font)
        text_width = bbox[2] - bbox[0]
        x = (width - text_width) // 2
        y = y_start + i * 20
        draw.text((x, y), line, fill=(255, 255, 255), font=font)
    
    img.save(filename, 'JPEG', quality=85)

def main():
    """Função principal"""
    # Criar diretórios se não existirem
    os.makedirs('assets/images', exist_ok=True)
    os.makedirs('assets/images/products', exist_ok=True)
    
    # Imagens do hero
    create_hero_image('assets/images/hero-model.jpg', 'COLEÇÃO PRIMAVERA', (255, 107, 105), (254, 202, 202))
    create_hero_image('assets/images/hero-model-2.jpg', 'COLEÇÃO VERÃO', (220, 38, 38), (254, 242, 242))
    create_hero_image('assets/images/hero-model-3.jpg', 'COLEÇÃO OUTONO', (255, 107, 105), (254, 202, 202))
    
    # Imagens dos produtos
    create_product_image('assets/images/products/conjunto-black.jpg', 'Conjunto Black', (51, 51, 51))
    create_product_image('assets/images/products/conjunto-prime-listras.jpg', 'Conjunto Prime Listras', (255, 182, 177))
    create_product_image('assets/images/products/conjunto-corvette.jpg', 'Conjunto Corvette', (255, 105, 180))
    create_product_image('assets/images/products/vestido-floral.jpg', 'Vestido Floral', (255, 182, 177))
    create_product_image('assets/images/products/blusa-branca.jpg', 'Blusa Branca', (245, 245, 245))
    create_product_image('assets/images/products/short-jeans.jpg', 'Short Jeans', (135, 206, 235))
    create_product_image('assets/images/products/camisa-vermelha.jpg', 'Camisa Vermelha', (220, 38, 38))
    create_product_image('assets/images/products/vestido-longo.jpg', 'Vestido Longo', (51, 51, 51))
    
    print("✅ Imagens criadas com sucesso!")

if __name__ == "__main__":
    main()

