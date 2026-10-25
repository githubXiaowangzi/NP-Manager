<?php
/**
 * MCP 帮助文档
 *
 * @since 2025/07/23
 */
header('Content-Type: text/html; charset=utf-8');
header('Cache-Control: no-store, no-cache, must-revalidate');
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NP Manager MCP 使用帮助</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
            color: #2c3e50;
            line-height: 1.8;
        }
        .container {
            max-width: 860px;
            margin: 0 auto;
            padding: 40px 20px;
        }
        /* Header */
        .header {
            background: #fff;
            border-radius: 16px;
            padding: 48px 40px 36px;
            margin-bottom: 32px;
            box-shadow: 0 2px 20px rgba(0,0,0,0.06);
            text-align: center;
            position: relative;
            overflow: hidden;
        }
        .header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #667eea, #764ba2);
        }
        .header h1 {
            font-size: 28px;
            font-weight: 700;
            color: #1a1a2e;
            margin-bottom: 8px;
        }
        .header p {
            font-size: 15px;
            color: #6b7280;
        }
        .header .badge {
            display: inline-block;
            margin-top: 12px;
            padding: 4px 14px;
            background: #eef2ff;
            color: #4f46e5;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 500;
        }
        /* Card */
        .card {
            background: #fff;
            border-radius: 16px;
            padding: 36px 40px;
            margin-bottom: 24px;
            box-shadow: 0 2px 20px rgba(0,0,0,0.06);
        }
        .card h2 {
            font-size: 20px;
            font-weight: 700;
            color: #1a1a2e;
            margin-bottom: 20px;
            padding-bottom: 12px;
            border-bottom: 2px solid #f0f0f5;
        }
        .card h2 .icon {
            margin-right: 8px;
        }
        .card h3 {
            font-size: 16px;
            font-weight: 600;
            color: #374151;
            margin: 24px 0 12px;
        }
        .card p, .card li {
            font-size: 15px;
            color: #4b5563;
        }
        .card ul, .card ol {
            padding-left: 24px;
        }
        .card li {
            margin-bottom: 6px;
        }
        /* Tool Grid */
        .tool-grid {
            display: grid;
            grid-template-columns: 1fr; /* 单列：长描述阅读体验优先 */
            gap: 14px;
            margin-top: 8px;
            align-items: start; /* 卡片按自身内容取高，消除同行 stretch 拉出的空白 */
        }
        /* 分类标题：横跨整行，可点击折叠/展开 */
        .tool-group-title {
            grid-column: 1 / -1;
            font-size: 15px;
            font-weight: 700;
            color: #4f46e5;
            background: #eef2ff;
            border-radius: 8px;
            padding: 8px 14px;
            margin-top: 10px;
            cursor: pointer;
            display: flex;
            align-items: center;
            user-select: none;
        }
        .tool-group-title small {
            font-weight: 400;
            color: #6b7280;
            font-size: 12px;
            margin-left: 8px;
        }
        .tool-group-title .chev {
            margin-left: auto;
            color: #9ca3af;
            font-size: 12px;
            transition: transform 0.2s;
        }
        .tool-group-title .chev::before { content: "\25BE"; }
        .tool-group.collapsed .tool-group-title .chev::before { content: "\25B8"; }
        .tool-group.collapsed .tool-group-body { display: none; }
        /* 锚点跳转预留吸顶导航的高度，避免组标题被遮挡 */
        .tool-group { scroll-margin-top: 64px; }
        @media (max-width: 600px) {
            .tool-group { scroll-margin-top: 118px; } /* 手机导航条换行更高 */
        }
        /* 卡片间距由 body 自己的 grid gap 提供（items 不再是外层 grid 的直接子元素） */
        .tool-group-body {
            display: grid;
            gap: 14px;
            padding: 14px 0 4px;
        }
        /* 分组锚点导航：吸顶 */
        .group-nav {
            grid-column: 1 / -1;
            position: sticky;
            top: 0;
            z-index: 20;
            display: flex;
            flex-wrap: wrap;
            gap: 6px;
            padding: 8px 10px;
            background: rgba(255,255,255,0.96);
            border: 1px solid #e5e7eb;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
            margin-bottom: 4px;
        }
        .group-nav a {
            font-size: 12px;
            padding: 4px 12px;
            background: #f3f4f6;
            border-radius: 14px;
            color: #4b5563;
        }
        .group-nav a.active { background: #667eea; color: #fff; }
        .tool-item {
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            padding: 18px 20px;
            transition: border-color 0.2s, box-shadow 0.2s;
            position: relative; /* 供出生日期角标定位 */
        }
        .tool-item .tool-birth {
            position: absolute;
            right: 14px;
            bottom: 10px;
            font-size: 11px;
            color: #b3bac4;
            letter-spacing: 0.3px;
        }
        .tool-item:hover {
            border-color: #667eea;
            box-shadow: 0 2px 12px rgba(102,126,234,0.1);
        }
        .tool-item .tool-name {
            font-family: 'SFMono-Regular', Consolas, 'Liberation Mono', Menlo, monospace;
            font-size: 14px;
            font-weight: 600;
            color: #4f46e5;
            margin-bottom: 4px;
        }
        .tool-item .tool-desc {
            font-size: 13px;
            color: #6b7280;
            line-height: 1.6;
            /* 75+ 工具描述普遍较长：默认 6 行截断保持扫读节奏，悬停展开全文 */
            display: -webkit-box;
            -webkit-line-clamp: 6;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        .tool-item:hover .tool-desc {
            -webkit-line-clamp: unset;
            overflow: visible;
        }
        /* 手机端无 hover：单列布局直接展示全文 */
        @media (max-width: 600px) {
            .tool-item .tool-desc {
                display: block;
                -webkit-line-clamp: unset;
                overflow: visible;
            }
        }
        .tool-item .tool-tag {
            display: inline-block;
            margin-top: 8px;
            padding: 2px 10px;
            font-size: 11px;
            border-radius: 10px;
            background: #f0fdf4;
            color: #16a34a;
        }
        .tool-item .tool-tag.destructive {
            background: #fef2f2;
            color: #dc2626;
        }
        /* Step */
        .step {
            display: flex;
            gap: 16px;
            margin-bottom: 20px;
            align-items: flex-start;
        }
        .step-num {
            flex-shrink: 0;
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            font-weight: 700;
            margin-top: 2px;
        }
        .step-content {
            flex: 1;
            min-width: 0;
        }
        .step-content p {
            margin-bottom: 4px;
        }
        .step-content .code {
            display: inline-block;
            font-family: 'SFMono-Regular', Consolas, 'Liberation Mono', Menlo, monospace;
            font-size: 13px;
            background: #f3f4f6;
            padding: 2px 8px;
            border-radius: 4px;
            color: #374151;
        }
        .step-content .highlight {
            background: #fefce8;
            padding: 10px 14px;
            border-radius: 8px;
            border-left: 3px solid #eab308;
            font-size: 14px;
            color: #713f12;
            margin-top: 8px;
        }
        /* Divider */
        .divider {
            text-align: center;
            margin: 32px 0 24px;
            color: #d1d5db;
            font-size: 20px;
            letter-spacing: 8px;
        }
        /* Footer */
        .footer {
            text-align: center;
            padding: 16px 0 8px;
            font-size: 13px;
            color: #9ca3af;
        }
        /* Link */
        a {
            color: #4f46e5;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
        /* ====== 能力引导 ====== */
        .intro-lead {
            font-size: 15px;
            color: #4b5563;
            margin-bottom: 14px;
        }
        .path {
            font-family: 'SFMono-Regular', Consolas, 'Liberation Mono', Menlo, monospace;
            font-size: 13px;
            color: #4f46e5;
            background: #eef2ff;
            padding: 1px 6px;
            border-radius: 4px;
        }
        .example-box {
            border: 1px solid #e0e7ff;
            border-left: 4px solid #667eea;
            border-radius: 12px;
            background: #f8faff;
            padding: 14px 18px;
            margin-bottom: 14px;
        }
        .example-label {
            display: inline-block;
            font-size: 12px;
            font-weight: 600;
            color: #4f46e5;
            background: #eef2ff;
            border-radius: 10px;
            padding: 2px 10px;
            margin-bottom: 8px;
        }
        .example-text {
            font-size: 14px;
            color: #374151;
            line-height: 1.9;
        }
        /* ====== 图片样式 ====== */
        /* 所有图片响应式 */
        .card img {
            display: block;
            max-width: 100%;
            height: auto;
            border-radius: 12px;
            box-shadow: 0 2px 12px rgba(0,0,0,0.08);
            margin: 12px auto;
        }
        /* 步骤内的图片容器 */
        .step-content .img-wrap {
            text-align: center;
            margin: 12px 0 4px;
        }
        /* 多图容器 — 三张截图横排 */
        .step-images {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            margin: 12px 0 4px;
            justify-content: center;
        }
        .step-images img {
            flex: 1 1 160px;
            max-width: 220px;
            min-width: 0;
            margin: 0; /* 覆盖 .card img 的 margin */
        }
        /* 手机窄屏：三张图两行排列 */
        @media (max-width: 560px) {
            .step-images {
                gap: 10px;
            }
            .step-images img {
                flex: 1 1 calc(50% - 5px);
                max-width: none;
            }
        }
        /* 极小屏：全宽单列 */
        @media (max-width: 380px) {
            .step-images img {
                flex: 1 1 100%;
            }
        }
    </style>
</head>
<body>
    <div class="container">

        <!-- ========== Header ========== -->
        <div class="header">
            <h1>NP Manager MCP 服务</h1>
            <p>通过 MCP 协议，让 AI 助手读懂、优化并完善你设备中的 APK——学习研究、提升质量、创造价值</p>
            <span class="badge" id="tool-count-badge">工具数量自动统计</span>
        </div>

        <!-- ========== Part 0: 能力引导 ========== -->
        <div class="card">
            <h2>先看看它能帮你做什么</h2>
            <p class="intro-lead">
                一句话：<strong>把 APK 交给 AI，说人话，拿结果。</strong>
                MCP 工具覆盖「理解 → 优化 → 构建 → 签名 → 安装 → 验证」完整闭环——
                AI 直接打开设备上的 APK，读懂并改善 Smali、界面布局、资源表、Dex 甚至 Native 库，
                改完自动签名装回手机跑给你看。不用反编译工具，不用敲命令，会聊天就会用。
            </p>
            <p class="intro-lead" style="margin-bottom:10px;"><strong>一句话能做好的事：</strong></p>
            <ul>
                <li><strong>应用研究</strong>：读懂权限与组件、验证签名来源、剖析代码结构与实现思路——像读开源项目一样读懂一个应用</li>
                <li><strong>体验优化</strong>：清理冗余代码与无用资源、按需精简多语言，让应用更轻、更快、更省电</li>
                <li><strong>本地化 / 改文案</strong>：resources.arsc 多语言增删改，字符串批量翻译补齐，让应用更懂你的用户</li>
                <li><strong>界面改进 / 加功能</strong>：布局元素级增删改，本地图片一键打包成 drawable，改完立刻看到效果</li>
                <li><strong>Dex 治理与重构</strong>：新增类、批量清理无用类、重命名规范包名类名——引用与清单全量同步</li>
                <li><strong>定制与修复</strong>：为测试场景调整应用标识，Smali / 字节 / SO 级精准修补，修复历史遗留问题</li>
            </ul>
            <p class="intro-lead" style="margin-top:14px;">
                <strong>我们的期待：</strong>愿这些能力被用于<strong>看清原理</strong>、<strong>优化体验</strong>、<strong>让应用更美</strong>——
                学习研究、提升质量、创造价值；请尊重开发者的劳动成果，遵守法律与许可约定。
            </p>
            <p class="intro-lead" style="margin-top:18px;margin-bottom:12px;">不知道怎么开口？照着这样说就行（把 <span class="path">/xxx/…</span> 换成你自己的路径）：</p>

            <div class="example-box">
                <span class="example-label">使用示例 1 · 资源表批量处理 + 全流程构建</span>
                <div class="example-text">「精简这个 <span class="path">/xxx/xxx/xxx.apk</span> 的多语言 string 配置，补充中英翻译并把默认语言换成日语，构建签名验证后装到手机上跑起来。」</div>
            </div>

            <div class="example-box">
                <span class="example-label">使用示例 2 · 界面改进 + 新增资源 + 图片打包</span>
                <div class="example-text">「帮我优化 <span class="path">/xxx/xxx/xxx.apk</span>：在“复制注册码”按钮下面加个“测试”按钮，文字和点击弹的 Toast（hello，np mcp）都用 resources.arsc 资源引用，背景图用 <span class="path">/xxx/xxx.png</span> 打包成 drawable，改完编译签名自动装到手机上打开。」</div>
            </div>

            <div class="example-box">
                <span class="example-label">使用示例 3 · Dex 治理（瘦身向）</span>
                <div class="example-text">「研究一下这个 <span class="path">/xxx/xxx/xxx.apk</span> 里某个历史遗留 SDK 的结构与引用关系：把已经不再使用的类批量清理、引用重写干净，再把包名重命名成规范形态，构建签名装回手机验证一切正常。」</div>
            </div>

            <p class="intro-lead" style="margin-top:18px;">
                然后？把本页地址配置进你的 MCP 客户端（如 Claude），说第一句话就行——
                AI 会自己挑工具、走流程、装回手机验证，你只管验收。
            </p>
        </div>

        <!-- ========== Part 1: 使用教程 ========== -->
        <div class="card">
            <h2>使用教程</h2>
            <p style="margin-bottom:16px;">以 <a href="https://rikka-ai.com/download" target="_blank">RikkaHub</a> 为例，演示如何配置并使用 NP Manager 的 MCP 服务。<br>
            RikkaHub 是一款简洁强大的安卓 AI 聊天客户端，支持 OpenAI、Google、Anthropic、DeepSeek 等主流 API 接口。</p>

                <div class="step">
                    <div class="step-num">1</div>
                    <div class="step-content">
                        <p><strong>下载并安装 RikkaHub</strong></p>
                        <p>访问 <a href="https://rikka-ai.com/download" target="_blank">rikka-ai.com/download</a> 下载 APK 并安装到设备上；也可使用下面的便捷下载直链（arm64-v8a，无需去官网）。</p>
                        <p><a href="http://normalplayer.top:8991/member/view/fileDownload/RikkaHub_3.0.0.apk" download style="display:inline-block;padding:8px 18px;border:1px solid #4a90d9;border-radius:6px;color:#4a90d9;text-decoration:none;font-weight:bold;">⬇ 便捷下载 RikkaHub 3.0.0（arm64-v8a）</a></p>
                    </div>
                </div>

            <div class="step">
                <div class="step-num">2</div>
                <div class="step-content">
                    <p><strong>添加 AI 提供商</strong></p>
                    <p>打开 RikkaHub，点击左侧底部的<span class="code">设置</span>按钮，进入<span class="code">提供商</span>页面添加你使用的 AI 服务（如 DeepSeek、OpenAI 等），并设置好要使用的模型。</p>
                </div>
            </div>

            <div class="step">
                <div class="step-num">3</div>
                <div class="step-content">
                    <p><strong>配置 MCP 服务器</strong></p>
                    <p>在 RikkaHub 设置中找到<span class="code">MCP 服务器</span>，添加一个新的 MCP：</p>
                    <ul>
                        <li>名称：<span class="code">NPMCP</span>（可自定义）</li>
                        <li>启用：打开开关</li>
                        <li>传输类型：选择 <span class="code">Streamable HTTP</span></li>
                    </ul>
                    <div class="img-wrap">                  
                       <img src="./images/s3.jpg" alt="配置 MCP 服务器截图"/>
                    </div>
                </div>
            </div>

            <div class="step">
                <div class="step-num">4</div>
                <div class="step-content">
                    <p><strong>启动 NP Manager MCP 服务</strong></p>
                    <p>打开 NP Manager，通过左侧导航栏进入<span class="code">工具 → APK MCP</span>，点击<span class="code">启动服务</span>按钮。</p>
                    <div class="highlight">服务启动后，点击局域网地址即可复制服务地址，格式如 <code>http://192.168.x.x:8787/mcp</code></div>
                </div>
            </div>

            <div class="step">
                <div class="step-num">5</div>
                <div class="step-content">
                    <p><strong>填写服务地址</strong></p>
                    <p>将上一步复制的地址粘贴到 RikkaHub MCP 配置中的<span class="code">服务地址</span>栏，然后保存。</p>
                    <div class="img-wrap">                  
                       <img src="./images/s5.jpg" alt="填写服务地址截图"/>
                    </div>
                </div>
            </div>

            <div class="step">
                <div class="step-num">6</div>
                <div class="step-content">
                    <p><strong>新建对话</strong></p>
                    <p>返回 RikkaHub 主界面，点击<span class="code">新对话</span>，在下方选择你已配置好的模型。</p>
                </div>
            </div>

            <div class="step">
                <div class="step-num">7</div>
                <div class="step-content">
                    <p><strong>启用 MCP 工具并开始使用</strong></p>
                    <p>在对话界面中，点击输入框旁边的<span class="code">+</span>号，选择<span class="code">MCP 服务器</span>，将 <span class="code">NPMCP</span> 设置为启用状态。</p>
                    <div class="highlight">现在你可以在聊天中让 AI 助手调用 NP Manager 的 MCP 工具了！例如：<br>
                    <em>「列出我手机里所有安装的应用」</em><br>
                    <em>「帮我查看 /sdcard/Download/ 目录下的文件」</em><br>
                    <em>「分析这个 APK 的权限和组件信息」</em></div>
                    <div class="step-images">                  
                       <img src="./images/s7-1.jpg" alt="启用 MCP 步骤 1"/>
                       <img src="./images/s7-2.jpg" alt="启用 MCP 步骤 2"/>     
                       <img src="./images/s7-3.jpg" alt="启用 MCP 步骤 3"/>    
                    </div>
                </div>
            </div>

            <div class="divider">· · ·</div>

            <h3>小提示</h3>
            <ul>
                <li>确保手机和 AI 客户端在同一局域网内，或在手机上开放端口映射</li>
                <li>MCP 服务支持多个客户端同时连接，每个客户端有独立的会话</li>
                <li>若服务地址变更，只需在 RikkaHub 中更新地址即可</li>
                <li>可在 MCP 对话框中设置端口和最大会话保留数量</li>
                <li>服务使用前台通知与 CPU WakeLock 保持运行，不申请 Wi-Fi 控制权限；局域网连接不稳定时请手动关闭 Wi-Fi 休眠，并将 NP Manager 加入电池优化白名单</li>
                <li>压缩、签名、APK 对比等长任务仍受 MCP 客户端工具超时限制；服务日志会记录 requestId、工具名与耗时，便于定位中断原因</li>
                <li>偶发"连接被拒绝 / Failed to connect"类报错多为服务进程瞬断或手机休眠断网：会话与未提交的编辑都保存在磁盘上，服务恢复后重开同一 APK 即可继续，不会丢工作；热更新/手动重启服务期间出现短暂连接拒绝属预期行为，重连后原样重试即可</li>
            </ul>
        </div>

        <!-- ========== Part 2: 工具介绍 ========== -->
        <div class="card">
            <h2>可用工具一览</h2>
            <p style="margin-bottom:16px;">NP Manager MCP 服务提供了以下工具，AI 助手可以在对话中直接调用：</p>

            <div class="tool-grid">
                <nav class="group-nav" id="group-nav"><a href="#grp-1" data-target="grp-1">打开应用</a><a href="#grp-2" data-target="grp-2">查看分析</a><a href="#grp-3" data-target="grp-3">内容编辑</a><a href="#grp-4" data-target="grp-4">Dex 操作</a><a href="#grp-5" data-target="grp-5">SO 库</a><a href="#grp-6" data-target="grp-6">构建装机</a><a href="#grp-7" data-target="grp-7">会话管理</a><a href="#grp-8" data-target="grp-8">文件通用</a><a href="#grp-9" data-target="grp-9">辅助</a></nav>
                <div class="tool-group" id="grp-1">
                <div class="tool-group-title">第一步 · 打开应用<small>处理任何 APK 都从这里开始</small><span class="chev" aria-hidden="true"></span></div>
                    <div class="tool-group-body">
                <div class="tool-item">
                    <div class="tool-name">np_apk_open</div>
                    <div class="tool-desc">打开 APK 建立工作区，先准备类列表再后台预热搜索；可查看排队原因，切换 APK 会保留旧工作区和未保存的编辑。</div>
                    <span class="tool-tag">只读</span>
                        <span class="tool-birth">2026-09-27</span>
                </div>
                <div class="tool-item">
                    <div class="tool-name">np_apk_list_available_apks</div>
                    <div class="tool-desc">查找可用 APK，同名构建产物会分组显示；可预览清理候选，删除前仍须逐项核对。</div>
                    <span class="tool-tag">只读</span>
                        <span class="tool-birth">2026-09-27</span>
                </div>
                <div class="tool-item">
                    <div class="tool-name">np_device_pull_apk</div>
                    <div class="tool-desc">把手机上已装的应用提取成 APK 文件。想研究已装应用的第一步；响应带总耗时和每个文件的耗时，大包等待心里有数。</div>
                    <span class="tool-tag destructive">写入</span>
                        <span class="tool-birth">2026-09-27</span>
                </div>
                <div class="tool-item">
                    <div class="tool-name">np_apk_edit_open</div>
                    <div class="tool-desc">开启一个编辑会话，之后所有修改都在会话里进行，不影响源 APK。有历史遗留会话时会提示怎么清理。</div>
                    <span class="tool-tag destructive">写入</span>
                        <span class="tool-birth">2026-09-27</span>
                </div>
                <div class="tool-item">
                    <div class="tool-name">np_apk_close</div>
                    <div class="tool-desc">删除用完的临时工作区；先停止资源和代码引用预热，仍在忙时保留目录并提示稍后重试，历史工作区不受影响。</div>
                    <span class="tool-tag destructive">写入</span>
                        <span class="tool-birth">2026-09-27</span>
                </div>
                <div class="tool-item">
                    <div class="tool-name">np_apk_release_cache</div>
                    <div class="tool-desc">内存紧张时释放某个工作区占用的缓存，不用关闭工作区；想保留资源解码结果可选软释放，之后读取不重付解析成本。</div>
                    <span class="tool-tag">只读</span>
                        <span class="tool-birth">2026-10-07</span>
                </div>
                    </div>
                </div>
                <div class="tool-group" id="grp-2">
                <div class="tool-group-title">先看懂它 · 查看与分析<small>信息、权限、代码、资源，全面体检</small><span class="chev" aria-hidden="true"></span></div>
                    <div class="tool-group-body">
                <div class="tool-item">
                    <div class="tool-name">np_get_apk_info</div>
                    <div class="tool-desc">看一个 APK 的基本档案：包名、版本、大小、权限、组件。拿到 APK 先摸底就用它。</div>
                    <span class="tool-tag">只读</span>
                        <span class="tool-birth">2026-09-27</span>
                </div>
                <div class="tool-item">
                    <div class="tool-name">np_apk_manifest</div>
                    <div class="tool-desc">看应用的“说明书”：权限、启动页、各组件声明。</div>
                    <span class="tool-tag">只读</span>
                        <span class="tool-birth">2026-09-27</span>
                </div>
                <div class="tool-item">
                    <div class="tool-name">np_apk_list</div>
                    <div class="tool-desc">列出 APK 里的类、文件和资源；工作区或会话失效时提示重新打开，精简输出也保留完整错误，读取基线时提醒会话修改未包含。资源名被混淆时按 0x 开头的资源 id 前缀（如 0x7f08）查，零结果会给出替代查法。看包内文件时可传 fields 只要 name/size 等少数字段，分页响应能小一半以上。新增“文本条目”视图：按文件内容筛出真正能当文本读的条目并给出探测编码（UTF-8 优先，其次 GBK/GB18030），res 下的二进制 XML、资源表和 dex 不会混进来，挑可编辑文件不必逐个试读。</div>
                    <span class="tool-tag">只读</span>
                        <span class="tool-birth">2026-09-27</span>
                </div>
                <div class="tool-item">
                    <div class="tool-name">np_apk_search</div>
                    <div class="tool-desc">搜索 APK 里的代码、资源和 SO 符号；大包首次预热与索引错峰，内存不足时提供失败阶段和重试建议。smali 正则支持 ^/$ 行首行尾锚定。</div>
                    <span class="tool-tag">只读</span>
                        <span class="tool-birth">2026-09-27</span>
                </div>
                <div class="tool-item">
                    <div class="tool-name">np_apk_native_prewarm_status</div>
                    <div class="tool-desc">分别查看 SO 字符串和符号预热的排队、进度及失败数量，便于排查首次搜索较慢的问题；查看进度不会启动任务。</div>
                    <span class="tool-tag">只读</span>
                    <span class="tool-birth">2026-10-16</span>
                </div>
                <div class="tool-item">
                    <div class="tool-name">np_apk_outline_class</div>
                    <div class="tool-desc">看一个类里有哪些方法和字段；必须传 dex_class locator，误传 className 会明确提示正确写法。</div>
                    <span class="tool-tag">只读</span>
                        <span class="tool-birth">2026-09-27</span>
                </div>
                <div class="tool-item">
                    <div class="tool-name">np_apk_read_text</div>
                    <div class="tool-desc">读取 APK 里的代码、布局和文本，编辑前先读它；默认紧凑档（教育说明折叠为短标记，传 compact=false 取回完整解释），基线读取会提示未包含会话修改。GBK 等非 UTF-8 文本文件传 encoding 即可正确显示（编码探测 UTF-8 优先，非 UTF-8 才按 GBK/GB18030 报，探测不出仍按 UTF-8 展示并提示疑似乱码）；这类文件不能按文本改，需用按字节写回。响应同时给文本域和字节域两个版本号，避免传错工具。</div>
                    <span class="tool-tag">只读</span>
                        <span class="tool-birth">2026-09-27</span>
                </div>
                <div class="tool-item">
                    <div class="tool-name">np_apk_read_resource</div>
                    <div class="tool-desc">读取资源当前值和引用链；支持单条或批量读取，默认紧凑档，存在编辑会话时标明基线风险，参数填错会指出具体位置。图标等二进制文件资源直接返回其在包内的文件路径（rawValueFallback 标记），可直接拿去抽取；variant 传 * 一次拿齐全部语言/密度变体的值。</div>
                    <span class="tool-tag">只读</span>
                        <span class="tool-birth">2026-09-27</span>
                </div>
                <div class="tool-item">
                    <div class="tool-name">np_apk_read_resource_tree</div>
                    <div class="tool-desc">浏览资源类型和语言配置，按类型筛选保持折叠；展开后复制准确配置路径，重复的基线风险说明会精简。展开视图下单个类型默认最多列 20 个配置节点（多语言/多密度包不再撑满响应），超出部分在类型节点上给出总数和剩余入口，传 configLimit 可调整或设 0 取全量。窗口读取的 entryOffset 是匹配条目内的跳过数，越界会明确报错并给出按 id 直取的替代路径。</div>
                    <span class="tool-tag">只读</span>
                        <span class="tool-birth">2026-09-27</span>
                </div>
                <div class="tool-item">
                    <div class="tool-name">np_apk_read_bytes</div>
                    <div class="tool-desc">读 APK 内文件的原始字节，核对二进制内容时用。</div>
                    <span class="tool-tag">只读</span>
                        <span class="tool-birth">2026-09-27</span>
                </div>
                <div class="tool-item">
                    <div class="tool-name">np_apk_signature</div>
                    <div class="tool-desc">看应用是谁签的名、用的什么证书、有没有被二次打包。</div>
                    <span class="tool-tag">只读</span>
                        <span class="tool-birth">2026-09-27</span>
                </div>
                <div class="tool-item">
                    <div class="tool-name">np_apk_entry_type</div>
                    <div class="tool-desc">识别 APK 里某个文件到底是什么格式（zip/png/dex/arsc/json/prof 等，按文件头判断，不看扩展名）。</div>
                    <span class="tool-tag">只读</span>
                        <span class="tool-birth">2026-09-27</span>
                </div>
                <div class="tool-item">
                    <div class="tool-name">np_apk_diff</div>
                    <div class="tool-desc">对比两个 APK 差在哪：类、方法、文件逐项列差异，改完前后对比用它。注意结果按新增/删除/修改分类展示，看修改要按提示切换类别；大包比 dex 可以传 dexEntries 只比变更的 dex（构建响应里直接给名单），全量太慢时开后台模式跑完再取结果。</div>
                    <span class="tool-tag">只读</span>
                        <span class="tool-birth">2026-09-27</span>
                </div>
                <div class="tool-item">
                    <div class="tool-name">np_apk_xref_resource</div>
                    <div class="tool-desc">查一个资源在哪里定义、被哪里使用；文件型资源会列出各语言或屏幕配置对应的实际文件路径。</div>
                    <span class="tool-tag">只读</span>
                        <span class="tool-birth">2026-09-27</span>
                </div>
                    </div>
                </div>
                <div class="tool-group" id="grp-3">
                <div class="tool-group-title">动手修改 · 内容编辑<small>改代码、改文案、换图、加删文件</small><span class="chev" aria-hidden="true"></span></div>
                    <div class="tool-group-body">
                <div class="tool-item">
                    <div class="tool-name">np_apk_edit_text</div>
                    <div class="tool-desc">修改 APK 会话里的代码和布局文本，支持按文字、行和元素定位；先读取再编辑，参数错误时整批拒绝，避免误删内容。</div>
                    <span class="tool-tag destructive">写入</span>
                        <span class="tool-birth">2026-09-27</span>
                </div>
                <div class="tool-item">
                    <div class="tool-name">np_apk_read_java</div>
                    <div class="tool-desc">把 APK 类的 Smali 转成 Java 方便阅读；转不出来时自动退回 Smali 伪代码视图（默认折叠 .line 调试噪音，需要原始视图传 includeLineInfo=true）。</div>
                    <span class="tool-tag">只读</span>
                </div>
                <div class="tool-item">
                    <div class="tool-name">np_apk_edit_resource</div>
                    <div class="tool-desc">改资源表：字符串、样式、多语言配置的增删改都在这里；一次可批量多条，失败整批回滚不会改一半；批量前可先试运行预览逐条增删改名单。克隆语言配置支持各国语言代码，不支持的语言码会说明原因，可顺手排除指定条目，改写克隆配置时直接给单条目即可；批量删除有确认门槛，整段替换时少提交的条目会在顶层醒目列出。</div>
                    <span class="tool-tag destructive">写入</span>
                        <span class="tool-birth">2026-09-27</span>
                </div>
                <div class="tool-item">
                    <div class="tool-name">np_apk_common_edit</div>
                    <div class="tool-desc">一句话改应用名、版本号、图标这类设置项；写完自动读回校验，不存在假成功。</div>
                    <span class="tool-tag destructive">写入</span>
                        <span class="tool-birth">2026-09-27</span>
                </div>
                <div class="tool-item">
                    <div class="tool-name">np_apk_edit_package_name</div>
                    <div class="tool-desc">改应用的包名（身份标识）。测试时要同时装多个版本时用。旧包名在 Manifest 里的逐处残留（文件、行号、属性）会一并列出，不用再手动全文搜。</div>
                    <span class="tool-tag destructive">写入</span>
                        <span class="tool-birth">2026-09-27</span>
                </div>
                <div class="tool-item">
                    <div class="tool-name">np_apk_patch_bytes</div>
                    <div class="tool-desc">插入、删除或替换 APK 内文件字节，可先预览；写入后核对完整内容，失败时恢复，回滚失败会明确提示。版本号要用字节域（read_bytes 或 read_text 的 byteTargetVersion），传文本域会明确报错并给出正确值。</div>
                    <span class="tool-tag destructive">写入</span>
                        <span class="tool-birth">2026-09-27</span>
                </div>
                <div class="tool-item">
                    <div class="tool-name">np_apk_write_entry_bytes</div>
                    <div class="tool-desc">一次调用直接把整个文件内容写进 APK：给十六进制或 base64 字节即可，GBK 等非 UTF-8 文本、小二进制文件都不用再落临时文件；写入有事务校验，失败会回滚。</div>
                    <span class="tool-tag destructive">写入</span>
                        <span class="tool-birth">2026-10-23</span>
                </div>
                <div class="tool-item">
                    <div class="tool-name">np_apk_add_files</div>
                    <div class="tool-desc">往 APK 里添加新文件；替换已有文件时会回显被覆盖内容的旧大小、旧版本和旧 CRC32，便于事后审计。</div>
                    <span class="tool-tag destructive">写入</span>
                        <span class="tool-birth">2026-09-27</span>
                </div>
                <div class="tool-item">
                    <div class="tool-name">np_apk_add_drawable</div>
                    <div class="tool-desc">把一张图片一键做成应用里的图片资源。加图标、换背景用它。</div>
                    <span class="tool-tag destructive">写入</span>
                        <span class="tool-birth">2026-09-28</span>
                </div>
                <div class="tool-item">
                    <div class="tool-name">np_apk_delete_files</div>
                    <div class="tool-desc">从 APK 里删掉文件；删的是会话新注册图片资源指向的文件时，资源注册会一并清掉。</div>
                    <span class="tool-tag destructive">写入</span>
                        <span class="tool-birth">2026-09-27</span>
                </div>
                <div class="tool-item">
                    <div class="tool-name">np_apk_extract_files</div>
                    <div class="tool-desc">从 APK 里把文件导出到手机存储。</div>
                    <span class="tool-tag destructive">写入</span>
                        <span class="tool-birth">2026-09-27</span>
                </div>
                    </div>
                </div>
                <div class="tool-group" id="grp-4">
                <div class="tool-group-title">Dex 代码级操作<small>类的增删改查与重命名</small><span class="chev" aria-hidden="true"></span></div>
                    <div class="tool-group-body">
                <div class="tool-item">
                    <div class="tool-name">np_apk_dex_stats</div>
                    <div class="tool-desc">看应用代码规模：多少类、多少方法、怎么分布；多个 classes.dex 按自然编号顺序展示，重复查询会复用内容版本缓存。</div>
                    <span class="tool-tag">只读</span>
                        <span class="tool-birth">2026-09-27</span>
                </div>
                <div class="tool-item">
                    <div class="tool-name">np_apk_dex_xref</div>
                    <div class="tool-desc">查“谁在用这个类或方法”，删改代码前先看影响范围；PUA 字符等 Unicode 混淆类名同样支持。</div>
                    <span class="tool-tag">只读</span>
                        <span class="tool-birth">2026-09-29</span>
                </div>
                <div class="tool-item">
                    <div class="tool-name">np_apk_dex_patch_instructions</div>
                    <div class="tool-desc">按指令位置修改代码，支持一次修改多处；符合条件时可快速构建，否则会说明原因并使用完整构建。</div>
                    <span class="tool-tag destructive">写入</span>
                </div>
                <div class="tool-item">
                    <div class="tool-name">np_apk_dex_delete_classes</div>
                    <div class="tool-desc">批量删除不需要的类，可以按包名整批删。删除前会预演影响面，连"改名前旧引用"这类隐蔽的悬空引用也能追到，构建体检还会再拦一道。</div>
                    <span class="tool-tag">写入</span>
                        <span class="tool-birth">2026-09-29</span>
                </div>
                <div class="tool-item">
                    <div class="tool-name">np_apk_dex_add_class</div>
                    <div class="tool-desc">往应用里加一个新类；结果里带每个新类的 classTargetVersion，后续编辑该类直接用。不指定落点时会自动挑代价最小的放法，大包不会为加一个类重编整个 dex；大包首次添加会自动转后台跑完再通知，不用盯着等。</div>
                    <span class="tool-tag">写入</span>
                        <span class="tool-birth">2026-09-29</span>
                </div>
                <div class="tool-item">
                    <div class="tool-name">np_apk_dex_create</div>
                    <div class="tool-desc">新建一个 dex 代码文件。</div>
                    <span class="tool-tag">写入</span>
                        <span class="tool-birth">2026-09-29</span>
                </div>
                <div class="tool-item">
                    <div class="tool-name">np_apk_dex_rename_class</div>
                    <div class="tool-desc">给一个类改名，所有用到它的地方自动同步。</div>
                    <span class="tool-tag">写入</span>
                        <span class="tool-birth">2026-09-29</span>
                </div>
                <div class="tool-item">
                    <div class="tool-name">np_apk_dex_rename_package</div>
                    <div class="tool-desc">整个包名批量改名，所有引用自动同步。大包预览或正式重命名都自动转后台任务，随时可取消；首次的耗时预估偏保守，跑过一次后按实测自动校准。</div>
                    <span class="tool-tag">写入</span>
                        <span class="tool-birth">2026-09-29</span>
                </div>
                    </div>
                </div>
                <div class="tool-group" id="grp-5">
                <div class="tool-group-title">Native（SO 库）<small>原生代码的分析与修改</small><span class="chev" aria-hidden="true"></span></div>
                    <div class="tool-group-body">
                <div class="tool-item">
                    <div class="tool-name">np_apk_native_inspect</div>
                    <div class="tool-desc">分析 SO 原生库的整体结构：架构、节数、依赖哪些库。</div>
                    <span class="tool-tag">只读</span>
                        <span class="tool-birth">2026-09-27</span>
                </div>
                <div class="tool-item">
                    <div class="tool-name">np_apk_native_read_items</div>
                    <div class="tool-desc">列出 SO 库里的函数、符号、依赖等明细。</div>
                    <span class="tool-tag">只读</span>
                        <span class="tool-birth">2026-09-27</span>
                </div>
                <div class="tool-item">
                    <div class="tool-name">np_apk_native_map_address</div>
                    <div class="tool-desc">把一个或多个 SO 地址和文件位置互相换算。</div>
                    <span class="tool-tag">只读</span>
                        <span class="tool-birth">2026-09-27</span>
                </div>
                <div class="tool-item">
                    <div class="tool-name">np_apk_native_disassemble</div>
                    <div class="tool-desc">把 SO 里的机器码翻译成汇编指令，可按地址或符号名定位；地址错位或指令模式冲突时会明确提示。</div>
                    <span class="tool-tag">只读</span>
                        <span class="tool-birth">2026-09-27</span>
                </div>
                <div class="tool-item">
                    <div class="tool-name">np_apk_native_xref</div>
                    <div class="tool-desc">查 SO 里谁引用了某个精确字节地址或符号，既可查代码也可查数据；不同架构的指令模式不能混用。</div>
                    <span class="tool-tag">只读</span>
                        <span class="tool-birth">2026-09-27</span>
                </div>
                <div class="tool-item">
                    <div class="tool-name">np_apk_native_function_cfg</div>
                    <div class="tool-desc">查看 SO 函数的执行流程，识别返回、分支和间接调用；可按正确对齐的地址或函数符号定位。</div>
                    <span class="tool-tag">只读</span>
                        <span class="tool-birth">2026-09-27</span>
                </div>
                <div class="tool-item">
                    <div class="tool-name">np_apk_native_pseudocode</div>
                    <div class="tool-desc">把 native 函数翻译成人能读的伪代码，方便看懂逻辑；只能看不能改，改动用补丁工具。个别复杂写法可能渲染失真，存疑时用反汇编交叉核对。</div>
                    <span class="tool-tag">只读</span>
                        <span class="tool-birth">2026-10-06</span>
                </div>
                <div class="tool-item">
                    <div class="tool-name">np_apk_native_patch_instructions</div>
                    <div class="tool-desc">修改 ARM、Thumb、ARM64、x86 和 x64 的 SO 汇编指令，可指定 CPU 扩展；与界面共用校验，先开启编辑会话。</div>
                    <span class="tool-tag">写入</span>
                        <span class="tool-birth">2026-09-27</span>
                </div>
                <div class="tool-item">
                    <div class="tool-name">np_apk_native_patch_string</div>
                    <div class="tool-desc">修改 SO 中的字符串，保留原始地址并核对完整字节范围。短值以空字符补齐，可能覆盖换行时会提醒。</div>
                    <span class="tool-tag">写入</span>
                        <span class="tool-birth">2026-09-27</span>
                </div>
                    </div>
                </div>
                <div class="tool-group" id="grp-6">
                <div class="tool-group-title">构建与装机<small>体检、打包、签名、安装、启动</small><span class="chev" aria-hidden="true"></span></div>
                    <div class="tool-group-body">
                <div class="tool-item">
                    <div class="tool-name">np_apk_edit_check</div>
                    <div class="tool-desc">打包前检查资源、代码和残留引用，给出通过与否，并预测默认选项下的代码补丁路径；实际执行结果在构建后查看。</div>
                    <span class="tool-tag destructive">写入</span>
                        <span class="tool-birth">2026-09-27</span>
                </div>
                <div class="tool-item">
                    <div class="tool-name">np_apk_session_diff</div>
                    <div class="tool-desc">改完先对账：一次看清这个会话相对原包改了哪些类、哪些方法、哪里改的，so 里的二进制补丁也算数，不用先打包再比对；没实际改动也会明说。</div>
                    <span class="tool-tag">只读</span>
                        <span class="tool-birth">2026-10-09</span>
                </div>
                <div class="tool-item">
                    <div class="tool-name">np_apk_verify_dex</div>
                    <div class="tool-desc">检查 APK 代码的静态风险并可结合系统校验，逐类处理以降低内存峰值；未完成的检查会明确标记，不能当作整包通过。</div>
                    <span class="tool-tag">只读</span>
                        <span class="tool-birth">2026-09-28</span>
                </div>
                <div class="tool-item">
                    <div class="tool-name">np_verify_status</div>
                    <div class="tool-desc">查看后台任务进度和结果，也能中途叫停；索引任务可查看排队原因和处理阶段，失败时保留具体原因和修复建议。</div>
                    <span class="tool-tag">只读</span>
                        <span class="tool-birth">2026-09-29</span>
                </div>
                <div class="tool-item">
                    <div class="tool-name">np_apk_build</div>
                    <div class="tool-desc">把会话修改打包并签名，显示实际补丁路径或重编码原因；可单次跳过自动清理，清理时保护刚生成的 APK。传 outputPath 可直接把产物放进目标目录，省一次复制；构建内置全部门禁，成功产出即权威结论，不需要再跑一次编辑检查。历史失败只统计真实写入失败，参数填错或编码/版本守卫拦截不计入。</div>
                    <span class="tool-tag destructive">写入</span>
                        <span class="tool-birth">2026-09-27</span>
                </div>
                <div class="tool-item">
                    <div class="tool-name">np_apk_build_plan</div>
                    <div class="tool-desc">构建前查看改动、检查结果和建议；可预览自动清理候选，预览不会删除文件或修改偏好。</div>
                    <span class="tool-tag">只读</span>
                        <span class="tool-birth">2026-10-01</span>
                </div>
                <div class="tool-item">
                    <div class="tool-name">np_sign_apk</div>
                    <div class="tool-desc">给 APK 签名，装手机必须有签名；构建完想换签名时用。</div>
                    <span class="tool-tag destructive">写入</span>
                        <span class="tool-birth">2026-09-27</span>
                </div>
                <div class="tool-item">
                    <div class="tool-name">np_apk_install</div>
                    <div class="tool-desc">安装或重装 APK，系统确认框需要人工处理；结果保留安装前后状态及任务关联，无法确认时明确说明。</div>
                    <span class="tool-tag destructive">写入</span>
                        <span class="tool-birth">2026-09-27</span>
                </div>
                <div class="tool-item">
                    <div class="tool-name">np_apk_launch</div>
                    <div class="tool-desc">启动已安装应用并核对前台；若启动输出明确提示系统限制，会附上依据和排查建议。</div>
                    <span class="tool-tag destructive">写入</span>
                        <span class="tool-birth">2026-09-27</span>
                </div>
                <div class="tool-item">
                    <div class="tool-name">np_device_screenshot</div>
                    <div class="tool-desc">截取手机当前屏幕保存成图片；可指定等某个应用在前台再截，抓错应用会明确警告。截屏瞬间前台不是目标应用时，图片默认改存为"路径+.mismatch"，避免拿别的应用截图冒充目标证据（响应里 savedTo/capturedPackage 标明真实文件和实际抓到的包名，captureOnMismatch=true 可恢复旧行为）。</div>
                    <span class="tool-tag destructive">写入</span>
                        <span class="tool-birth">2026-09-30</span>
                </div>
                <div class="tool-item">
                    <div class="tool-name">np_device_status</div>
                    <div class="tool-desc">一键查看 Root、Shizuku 等后端是否可用、有哪些能力；设备情况不明时先调它。</div>
                    <span class="tool-tag">只读</span>
                        <span class="tool-birth">2026-10-03</span>
                </div>
                <div class="tool-item">
                    <div class="tool-name">np_device_ui_dump</div>
                    <div class="tool-desc">抓取当前页面控件树，让 AI 看懂界面上有什么；指定包名时只返回该应用的控件，避免混入别的应用界面；无 Root/Shizuku 时不可用。</div>
                    <span class="tool-tag destructive">写入</span>
                        <span class="tool-birth">2026-09-30</span>
                </div>
                <div class="tool-item">
                    <div class="tool-name">np_device_ui_assert</div>
                    <div class="tool-desc">断言界面上某个控件存在/不存在，自动给出通过或不通过；目标应用不在前台时结果一律按"没判完"处理，不会被别的应用的文字骗通过；冷启动等太久时同样明说而不是卡住；Toast 弹没弹也能自动检测（只判窗口、不读文字），文字内容仍需人工看图确认。</div>
                    <span class="tool-tag">只读</span>
                        <span class="tool-birth">2026-10-01</span>
                </div>
                <div class="tool-item">
                    <div class="tool-name">np_device_ui_click</div>
                    <div class="tool-desc">点击界面上的一个控件，可顺带截图留证；应用被切后台时自动拉回再点；指定包名时只在目标应用里找控件，防止误点其他应用的同名按钮。想自动确认 Toast 弹没弹，加 expectToast 参数。</div>
                    <span class="tool-tag destructive">写入</span>
                        <span class="tool-birth">2026-10-01</span>
                </div>
                <div class="tool-item">
                    <div class="tool-name">np_device_ui_input</div>
                    <div class="tool-desc">向输入框输入文字；应用在后台时自动拉回再输入。输入后会回读输入框确认文字真正写入，没写进来自动重试一次并如实提示。</div>
                    <span class="tool-tag destructive">写入</span>
                        <span class="tool-birth">2026-10-01</span>
                </div>
                <div class="tool-item">
                    <div class="tool-name">np_device_logcat</div>
                    <div class="tool-desc">读取设备日志，支持按时间范围和 crash 缓冲区查询并返回日志覆盖时间；带 sinceMs 时先按时间过滤再截断，首页命中目标时刻附近的历史日志，一页读不完会给出按时间前移的续读游标；请求的时间窗早于日志缓冲区时明说"窗内无日志"，不会拿边界信息冒充日志内容；按包名过滤时找不到进程号会自动改用多种方式定位或退化为包名匹配而不是报错；跨包观测受限时不要据此判断崩溃，稳定性问题请改用崩溃报告工具；输出行数受请求上限约束并附体积预估，超限的崩溃堆栈按整条事件裁剪、异常头保持完整。</div>
                    <span class="tool-tag">只读</span>
                        <span class="tool-birth">2026-10-01</span>
                </div>
                <div class="tool-item">
                    <div class="tool-name">np_device_crash_report</div>
                    <div class="tool-desc">按包名在有限预算内查询持久化的 Java/native 崩溃、ANR 和可用 tombstone 摘要；超时返回部分结果而不会挂起，点击后进程退出时先用它定位原因，再重试界面验证。</div>
                    <span class="tool-tag">只读</span>
                        <span class="tool-birth">2026-10-02</span>
                </div>
                <div class="tool-item">
                    <div class="tool-name">np_device_smoke_test</div>
                    <div class="tool-desc">一键冒烟测试：自动启动应用、按顺序点击/输入、断言、截图、查日志；断言基于步骤完成后的最新界面判定；输入后自动收起键盘，被抢前台时自动拉回再继续；全程有服务端时间预算保护，步骤再长也不会把请求拖到客户端超时。</div>
                    <span class="tool-tag destructive">写入</span>
                        <span class="tool-birth">2026-10-01</span>
                </div>
                <div class="tool-item">
                    <div class="tool-name">np_apk_runtime_report</div>
                    <div class="tool-desc">经用户同意后汇总已安装应用信息、当前界面、截图和日志证据，崩溃检测合并日志与系统 DropBox 落盘记录双源（刚装完就闪退这类日志抓不到的崩溃也能检出，只认最近 30 分钟的记录防历史误报）；某阶段因超预算被跳过不算失败，只有真正失败才标记 partial 并点名；仅作辅助诊断，不是正式验收。</div>
                    <span class="tool-tag destructive">写入</span>
                        <span class="tool-birth">2026-10-01</span>
                </div>
                <div class="tool-item">
                    <div class="tool-name">np_apk_hash_files</div>
                    <div class="tool-desc">对比构建前后的文件指纹，确认修改真的打进包里了。</div>
                    <span class="tool-tag">只读</span>
                        <span class="tool-birth">2026-09-27</span>
                </div>
                    </div>
                </div>
                <div class="tool-group" id="grp-7">
                <div class="tool-group-title">会话管理<small>编辑会话的查看与清理</small><span class="chev" aria-hidden="true"></span></div>
                    <div class="tool-group-body">
                <div class="tool-item">
                    <div class="tool-name">np_apk_session_list</div>
                    <div class="tool-desc">列出所有编辑会话，各自改了什么一目了然；写冲突时来这看是谁占着锁。</div>
                    <span class="tool-tag">只读</span>
                        <span class="tool-birth">2026-09-28</span>
                </div>
                <div class="tool-item">
                    <div class="tool-name">np_apk_session_delete</div>
                    <div class="tool-desc">删掉不用的编辑会话，做清理。</div>
                    <span class="tool-tag destructive">写入</span>
                        <span class="tool-birth">2026-09-28</span>
                </div>
                <div class="tool-item">
                    <div class="tool-name">np_apk_session_gc</div>
                    <div class="tool-desc">先预览再批量清理陈旧的编辑会话，默认保护未提交的修改，不会误删。</div>
                    <span class="tool-tag destructive">写入</span>
                        <span class="tool-birth">2026-10-01</span>
                </div>
                    </div>
                </div>
                <div class="tool-group" id="grp-8">
                <div class="tool-group-title">文件与系统通用<small>手机文件操作，与 APK 无关也通用</small><span class="chev" aria-hidden="true"></span></div>
                    <div class="tool-group-body">
                <div class="tool-item">
                    <div class="tool-name">np_list_directory</div>
                    <div class="tool-desc">列出手机某个文件夹里有什么，找文件用；没权限的地方会如实说明，不会装成空文件夹；像 /data 这类只能看到一部分的目录也会明说列表不完整。</div>
                    <span class="tool-tag">只读</span>
                        <span class="tool-birth">2026-09-27</span>
                </div>
                <div class="tool-item">
                    <div class="tool-name">np_get_file_info</div>
                    <div class="tool-desc">查文件多大、什么时候改的，确认文件是否存在时用；特权通道下会明确给出可读/可写结论（无法确定时会标注）。</div>
                    <span class="tool-tag">只读</span>
                        <span class="tool-birth">2026-09-27</span>
                </div>
                <div class="tool-item">
                    <div class="tool-name">np_search_text_in_files</div>
                    <div class="tool-desc">在多个文件里搜文字，二进制文件自动跳过；大目录分页搜索，一页扫不完会给续搜口令，交回去接着扫。</div>
                    <span class="tool-tag">只读</span>
                        <span class="tool-birth">2026-09-27</span>
                </div>
                <div class="tool-item">
                    <div class="tool-name">np_file_search_text</div>
                    <div class="tool-desc">在单个文件里搜文字，支持正则和分页，命中行号按 1 起算；翻页按提示交给续读工具。</div>
                    <span class="tool-tag">只读</span>
                        <span class="tool-birth">2026-09-27</span>
                </div>
                <div class="tool-item">
                    <div class="tool-name">np_file_read_text</div>
                    <div class="tool-desc">按行读取文本，支持大文件；少量安全的系统信息文件可通过受限读取查看，不能在此编辑。</div>
                    <span class="tool-tag">只读</span>
                        <span class="tool-birth">2026-09-27</span>
                </div>
                <div class="tool-item">
                    <div class="tool-name">np_file_edit_text</div>
                    <div class="tool-desc">替换、插入或删除文本文件内容，按版本锁防覆盖；参数拼错或缺少写入内容时整批拒绝，删除文字需明确填写空内容。</div>
                    <span class="tool-tag">写入</span>
                        <span class="tool-birth">2026-09-27</span>
                </div>
                <div class="tool-item">
                    <div class="tool-name">np_file_read_bytes</div>
                    <div class="tool-desc">按窗口查看文件的十六进制字节；也能安全读取少量系统信息文件，设备节点等特殊文件会被拒绝。</div>
                    <span class="tool-tag">只读</span>
                        <span class="tool-birth">2026-09-27</span>
                </div>
                <div class="tool-item">
                    <div class="tool-name">np_file_patch_bytes</div>
                    <div class="tool-desc">按整数字节位置修改文件内容，支持插入、删除和替换；修改前先核对文件版本，任一补丁不匹配时整批不动。</div>
                    <span class="tool-tag destructive">写入</span>
                        <span class="tool-birth">2026-09-27</span>
                </div>
                <div class="tool-item">
                    <div class="tool-name">np_file_search_bytes</div>
                    <div class="tool-desc">在文件或压缩包条目（解压后）里搜十六进制字节，支持一次多个模式、密码加密包与跨条目续扫；条目前缀筛选用顶层 entryPrefix 按条目全路径匹配；全范围搜索扫完整个范围不截断；压缩包本体搜不到会提醒先解压；权限被拒会明确报 PERMISSION_DENIED 并附恢复指引，不再笼统报扫描失败。</div>
                    <span class="tool-tag">只读</span>
                        <span class="tool-birth">2026-09-27</span>
                </div>
                <div class="tool-item">
                    <div class="tool-name">np_file_hash_files</div>
                    <div class="tool-desc">计算文件或压缩包条目的指纹以核对内容；支持少量安全系统信息文件，每项失败都会说明原因。</div>
                    <span class="tool-tag">只读</span>
                        <span class="tool-birth">2026-09-27</span>
                </div>
                <div class="tool-item">
                    <div class="tool-name">np_file_compress</div>
                    <div class="tool-desc">把文件打包压缩成 zip、7z 等格式；zip 和 7z 支持传密码创建加密包。打包文件夹会保留文件夹名作为前缀，响应会附上真实条目名清单，避免猜名字。</div>
                    <span class="tool-tag destructive">写入</span>
                        <span class="tool-birth">2026-09-27</span>
                </div>
                <div class="tool-item">
                    <div class="tool-name">np_file_extract</div>
                    <div class="tool-desc">解压压缩包，取出里面的文件。</div>
                    <span class="tool-tag destructive">写入</span>
                        <span class="tool-birth">2026-09-27</span>
                </div>
                <div class="tool-item">
                    <div class="tool-name">np_file_list_archive</div>
                    <div class="tool-desc">不解压也能看压缩包里有哪些文件：按路径前缀、通配符和文件/目录筛选，结果分页返回；加密包先传密码。</div>
                    <span class="tool-tag">只读</span>
                        <span class="tool-birth">2026-10-23</span>
                </div>
                <div class="tool-item">
                    <div class="tool-name">np_file_edit_zip</div>
                    <div class="tool-desc">直接改 zip 包：加文件、删文件、换文件，不用先解压再打包。</div>
                    <span class="tool-tag destructive">写入</span>
                        <span class="tool-birth">2026-09-27</span>
                </div>
                <div class="tool-item">
                    <div class="tool-name">np_file_exists</div>
                    <div class="tool-desc">问一下某个文件存不存在；权限看不到的地方会如实说明，不会谎报不存在。</div>
                    <span class="tool-tag">只读</span>
                        <span class="tool-birth">2026-09-27</span>
                </div>
                <div class="tool-item">
                    <div class="tool-name">np_file_delete</div>
                    <div class="tool-desc">删文件或文件夹（需要确认防手滑；预览模式不用确认；系统目录一律拒删）。</div>
                    <span class="tool-tag destructive">写入</span>
                        <span class="tool-birth">2026-09-27</span>
                </div>
                <div class="tool-item">
                    <div class="tool-name">np_file_output_cleanup</div>
                    <div class="tool-desc">清理 MCP 输出目录里重复的旧产物：每组保留最新几份，多余的删掉；你手动放的原始文件和正在使用的工作区源 APK 永久保护。先预览再确认，绝不误删。</div>
                    <span class="tool-tag destructive">写入</span>
                        <span class="tool-birth">2026-10-06</span>
                </div>
                <div class="tool-item">
                    <div class="tool-name">np_file_move</div>
                    <div class="tool-desc">移动或重命名文件（源文件会消失，这是移动不是复制；想保留原文件请用复制类工具）。</div>
                    <span class="tool-tag destructive">写入</span>
                        <span class="tool-birth">2026-09-27</span>
                </div>
                <div class="tool-item">
                    <div class="tool-name">np_write_file</div>
                    <div class="tool-desc">把文字保存成手机文件，不指定编码默认按 UTF-8（老编码文件仍要求写明编码）；覆盖已有文件需要显式确认，系统保护目录写不进去。</div>
                    <span class="tool-tag destructive">写入</span>
                        <span class="tool-birth">2026-09-27</span>
                </div>
                <div class="tool-item">
                    <div class="tool-name">np_file_append</div>
                    <div class="tool-desc">往文件末尾追加内容，不动原有部分；多行内容可用 contentChunks 数组分块传入，防止换行在客户端被转义；不指定编码默认按 UTF-8（老编码文件仍要求写明编码）。</div>
                    <span class="tool-tag destructive">写入</span>
                        <span class="tool-birth">2026-09-27</span>
                </div>
                <div class="tool-item">
                    <div class="tool-name">np_write_file_from</div>
                    <div class="tool-desc">把电脑上的文件传到手机。传图片、压缩包等大文件都用它。</div>
                    <span class="tool-tag destructive">写入</span>
                        <span class="tool-birth">2026-09-27</span>
                </div>
                <div class="tool-item">
                    <div class="tool-name">np_execute_shell</div>
                    <div class="tool-desc">执行 shell 命令，返回结构化的标准输出、错误输出和退出码；可先 dryRun 预览风险分类，高风险操作仍需明确确认。</div>
                    <span class="tool-tag destructive">写入</span>
                        <span class="tool-birth">2026-09-27</span>
                </div>
                <div class="tool-item">
                    <div class="tool-name">np_list_installed_apps</div>
                    <div class="tool-desc">列出手机上装了哪些应用，可搜索、按时间或大小排序；想知道装了什么、查某应用信息时用。</div>
                    <span class="tool-tag">只读</span>
                        <span class="tool-birth">2026-09-27</span>
                </div>
                    </div>
                </div>
                <div class="tool-group" id="grp-9">
                <div class="tool-group-title">辅助工具<small>分页续读、查说明书</small><span class="chev" aria-hidden="true"></span></div>
                    <div class="tool-group-body">
                <div class="tool-item">
                    <div class="tool-name">np_apk_continue</div>
                    <div class="tool-desc">继续读上次搜索、列表或本地文件分页结果的下一页；必须原样复制上一页 nextActions 里的 cursor，不能手工改写。</div>
                    <span class="tool-tag">只读</span>
                        <span class="tool-birth">2026-09-27</span>
                </div>
                <div class="tool-item">
                    <div class="tool-name">np_help</div>
                    <div class="tool-desc">让 AI 按需查工具的完整说明和用法专题；遇到报错可以按错误码查官方处置建议。</div>
                    <span class="tool-tag">只读</span>
                        <span class="tool-birth">2026-09-27</span>
                </div>
                <div class="tool-item">
                    <div class="tool-name">np_get_time_info</div>
                    <div class="tool-desc">查手机当前的时间、日期和时区，安排设备定时任务时用；电脑时间请查看宿主侧时钟。</div>
                    <span class="tool-tag">只读</span>
                        <span class="tool-birth">2026-09-30</span>
                </div>
                <div class="tool-item">
                    <div class="tool-name">np_get_session_stats</div>
                    <div class="tool-desc">统计调用次数、耗时和最慢调用，按阶段复盘；工作区台账可跨重启查询，后台任务耗时单列，调用时间跨度与累计耗时分别展示。没有工作区归属的本地文件调用会单独披露；按时间窗查询时不再给出容易误读的覆盖率，改为并列“窗口内归因次数”和“进程级本池次数”两个绝对值（本地池没有逐调用时间戳），窗口内本地调用的口径说明在精简档下也会保留。</div>
                    <span class="tool-tag">只读</span>
                        <span class="tool-birth">2026-10-08</span>
                </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer">
            NP Manager &mdash; MCP 服务 v1.1<br>
            <span style="font-size:13px;color:#9ca3af;">最后更新：2026-10-07</span>
        </div>

    </div>
    <script>
        // 工具总数自动统计：跟随下方 tool-name 条目数量，避免手工维护失步
        (function () {
            var badge = document.getElementById("tool-count-badge");
            if (!badge) return;
            var count = document.querySelectorAll(".tool-name").length;
            badge.textContent = count + " 个可用工具";
        })();

        // 分组手风琴 + 锚点导航：默认展开第一组，点标题切换，点导航跳组
        (function () {
            var groups = Array.prototype.slice.call(document.querySelectorAll(".tool-group"));
            if (!groups.length) return;
            function setGroupOpen(g, open) { g.classList.toggle("collapsed", !open); }
            groups.forEach(function (g, i) { setGroupOpen(g, i === 0); });
            document.querySelectorAll(".tool-group-title").forEach(function (t) {
                t.addEventListener("click", function () {
                    var g = t.parentElement;
                    var wasOpen = !g.classList.contains("collapsed");
                    groups.forEach(function (x) { setGroupOpen(x, false); });
                    if (!wasOpen) setGroupOpen(g, true);
                });
            });
            var nav = document.getElementById("group-nav");
            if (!nav) return;
            nav.querySelectorAll("a").forEach(function (a) {
                a.addEventListener("click", function (e) {
                    e.preventDefault();
                    var g = document.getElementById(a.getAttribute("data-target"));
                    if (!g) return;
                    groups.forEach(function (x) { setGroupOpen(x, false); });
                    setGroupOpen(g, true);
                    nav.querySelectorAll("a").forEach(function (x) { x.classList.remove("active"); });
                    a.classList.add("active");
                    g.scrollIntoView({ behavior: "smooth", block: "start" });
                });
            });
        })();
    </script>
</body>
</html>
