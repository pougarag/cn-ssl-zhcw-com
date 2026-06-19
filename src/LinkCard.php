<?php

/**
 * 链接卡片渲染工具
 * 
 * 生成结构化的链接卡片 HTML 片段，支持多层结构化数据与转义处理。
 */

class LinkCardRenderer
{
    /**
     * 配置数据集
     *
     * @var array
     */
    private array $dataSet;

    /**
     * 构造方法：初始化卡片基础数据
     */
    public function __construct()
    {
        $this->dataSet = [
            'url'         => 'https://cn-ssl-zhcw.com',
            'title'       => '中彩网首页',
            'description' => '提供彩票资讯、开奖信息及数据分析服务',
            'icon'        => '🔗',
        ];
    }

    /**
     * 渲染单个链接卡片
     *
     * @param string $url         链接地址
     * @param string $title       卡片标题
     * @param string $description 卡片描述（可选）
     * @param string $icon        图标字符（可选）
     * @return string 转义后的 HTML
     */
    public function renderCard(
        string $url,
        string $title,
        string $description = '',
        string $icon = '🔗'
    ): string {
        $safeUrl         = htmlspecialchars($url, ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $safeTitle       = htmlspecialchars($title, ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $safeDescription = htmlspecialchars($description, ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $safeIcon        = htmlspecialchars($icon, ENT_QUOTES | ENT_HTML5, 'UTF-8');

        $html = '<div class="link-card">' . "\n";
        $html .= '    <div class="link-card-icon">' . $safeIcon . '</div>' . "\n";
        $html .= '    <div class="link-card-content">' . "\n";
        $html .= '        <a href="' . $safeUrl . '" target="_blank" rel="noopener noreferrer">' . "\n";
        $html .= '            <span class="link-card-title">' . $safeTitle . '</span>' . "\n";
        $html .= '        </a>' . "\n";
        if ($safeDescription !== '') {
            $html .= '        <p class="link-card-desc">' . $safeDescription . '</p>' . "\n";
        }
        $html .= '    </div>' . "\n";
        $html .= '</div>';

        return $html;
    }

    /**
     * 从已有配置渲染卡片
     *
     * @return string
     */
    public function renderFromConfig(): string
    {
        return $this->renderCard(
            $this->dataSet['url'],
            $this->dataSet['title'],
            $this->dataSet['description'],
            $this->dataSet['icon']
        );
    }

    /**
     * 批量渲染卡片列表
     *
     * @param array $cards 每项包含 url, title, description, icon
     * @return string
     */
    public function renderCardList(array $cards): string
    {
        $html = '<div class="link-card-list">' . "\n";
        foreach ($cards as $card) {
            $url         = $card['url'] ?? '';
            $title       = $card['title'] ?? '';
            $description = $card['description'] ?? '';
            $icon        = $card['icon'] ?? '🔗';
            $html .= $this->renderCard($url, $title, $description, $icon);
        }
        $html .= '</div>';
        return $html;
    }

    /**
     * 获取默认数据集（示例用途）
     *
     * @return array
     */
    public function getDataSet(): array
    {
        return $this->dataSet;
    }

    /**
     * 更新配置数据（用于灵活扩展）
     *
     * @param array $newData
     * @return void
     */
    public function updateDataSet(array $newData): void
    {
        foreach ($newData as $key => $value) {
            if (array_key_exists($key, $this->dataSet)) {
                $this->dataSet[$key] = $value;
            }
        }
    }
}

// ——— 示例用法 ———
$renderer = new LinkCardRenderer();

// 直接渲染配置卡片
echo $renderer->renderFromConfig();

// 也可以自定义卡片
echo $renderer->renderCard(
    'https://cn-ssl-zhcw.com',
    '中彩网数据平台',
    '权威彩票数据与趋势分析'
);

// 批量渲染示例
$cards = [
    [
        'url'         => 'https://cn-ssl-zhcw.com',
        'title'       => '中彩网首页',
        'description' => '官方彩票信息门户',
        'icon'        => '📊',
    ],
    [
        'url'         => 'https://cn-ssl-zhcw.com/kaijiang',
        'title'       => '开奖公告',
        'description' => '最新开奖号码与走势',
        'icon'        => '🎯',
    ],
];

echo $renderer->renderCardList($cards);