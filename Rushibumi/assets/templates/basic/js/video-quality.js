/**
 * Video Quality Management for Plyr.js
 * Provides YouTube-like quality selection functionality with actual resolution detection
 */

class VideoQualityManager {
    constructor(player, videoElement) {
        this.player = player;
        this.videoElement = videoElement;
        this.availableQualities = [];
        this.currentQuality = null;
        this.qualityButton = null;
        this.videoId = this.getVideoId();
        
        this.init();
    }

    init() {
        this.detectAvailableQualities();
        this.createQualityButton();
        this.bindEvents();
    }

    getVideoId() {
        // Try to get video ID from various sources
        const videoContainer = this.videoElement.closest('[data-video-id]');
        if (videoContainer) {
            return videoContainer.getAttribute('data-video-id');
        }
        
        // Check for video ID in URL or other attributes
        const urlMatch = window.location.pathname.match(/\/video\/(\d+)/);
        if (urlMatch) {
            return urlMatch[1];
        }
        
        return null;
    }

    async detectAvailableQualities() {
        const sources = this.videoElement.querySelectorAll('source');
        this.availableQualities = [];
        
        // First, try to get qualities from server
        if (this.videoId) {
            try {
                const response = await fetch(`/api/video/${this.videoId}/qualities`);
                if (response.ok) {
                    const data = await response.json();
                    if (data.status === 'success') {
                        this.availableQualities = data.qualities.map(q => ({
                            id: q.id,
                            quality: q.quality,
                            width: q.width,
                            height: q.height,
                            src: q.url,
                            type: 'video/mp4'
                        }));
                        console.log('Server qualities:', this.availableQualities);
                        return;
                    }
                }
            } catch (error) {
                console.log('Could not fetch server qualities, falling back to source detection');
            }
        }
        
        // Fallback to source detection
        sources.forEach(source => {
            const quality = source.getAttribute('size') || this.detectQualityFromSrc(source.src);
            this.availableQualities.push({
                id: null,
                quality: quality,
                width: this.getWidthFromQuality(quality),
                height: this.getHeightFromQuality(quality),
                src: source.src,
                type: source.type
            });
        });

        // Sort qualities in descending order
        this.availableQualities.sort((a, b) => this.getQualityOrder(a.quality) - this.getQualityOrder(b.quality));
        
        console.log('Available qualities:', this.availableQualities);
    }

    detectQualityFromSrc(src) {
        // Try to detect quality from filename
        if (src.includes('1080')) return '1080p';
        if (src.includes('720')) return '720p';
        if (src.includes('480')) return '480p';
        if (src.includes('360')) return '360p';
        if (src.includes('240')) return '240p';
        return 'auto';
    }

    getWidthFromQuality(quality) {
        const qualityMap = {
            '1080p': 1920,
            '720p': 1280,
            '480p': 854,
            '360p': 640,
            '240p': 426
        };
        return qualityMap[quality] || 0;
    }

    getHeightFromQuality(quality) {
        const qualityMap = {
            '1080p': 1080,
            '720p': 720,
            '480p': 480,
            '360p': 360,
            '240p': 240
        };
        return qualityMap[quality] || 0;
    }

    getQualityOrder(quality) {
        const order = {
            '1080p': 1,
            '720p': 2,
            '480p': 3,
            '360p': 4,
            '240p': 5,
            'auto': 6
        };
        return order[quality] || 7;
    }

    createQualityButton() {
        if (this.availableQualities.length <= 1) return;

        // Create quality button
        this.qualityButton = document.createElement('button');
        this.qualityButton.className = 'plyr__control plyr__control--quality';
        this.qualityButton.setAttribute('data-plyr', 'quality');
        this.qualityButton.setAttribute('aria-label', 'Quality');
        this.qualityButton.innerHTML = `
            <span class="plyr__sr-only">Quality</span>
            <span class="quality-label">${this.getCurrentQualityLabel()}</span>
        `;

        // Add to controls
        const controls = this.player.elements.controls;
        if (controls) {
            const settingsButton = controls.querySelector('[data-plyr="settings"]');
            if (settingsButton) {
                settingsButton.parentNode.insertBefore(this.qualityButton, settingsButton);
            }
        }
    }

    getCurrentQualityLabel() {
        const currentSrc = this.videoElement.currentSrc;
        const currentQuality = this.availableQualities.find(q => q.src === currentSrc);
        return currentQuality ? `${currentQuality.quality}p` : 'Auto';
    }

    bindEvents() {
        if (!this.qualityButton) return;

        this.qualityButton.addEventListener('click', (e) => {
            e.preventDefault();
            this.showQualityMenu();
        });

        // Listen for video source changes
        this.videoElement.addEventListener('loadstart', () => {
            this.updateQualityLabel();
        });
    }

    showQualityMenu() {
        // Remove existing menu
        const existingMenu = document.querySelector('.quality-menu');
        if (existingMenu) {
            existingMenu.remove();
            return;
        }

        // Create quality menu
        const menu = document.createElement('div');
        menu.className = 'quality-menu';
        menu.innerHTML = `
            <div class="quality-menu__header">Quality</div>
            <div class="quality-menu__items">
                ${this.availableQualities.map(quality => `
                    <button class="quality-menu__item" data-quality="${quality.quality}">
                        <span class="quality-menu__label">${quality.quality}p</span>
                        ${this.isCurrentQuality(quality) ? '<span class="quality-menu__check">✓</span>' : ''}
                    </button>
                `).join('')}
            </div>
        `;

        // Position menu
        const rect = this.qualityButton.getBoundingClientRect();
        menu.style.position = 'absolute';
        menu.style.bottom = '100%';
        menu.style.left = '50%';
        menu.style.transform = 'translateX(-50%)';
        menu.style.zIndex = '1000';
        menu.style.backgroundColor = 'rgba(0, 0, 0, 0.9)';
        menu.style.borderRadius = '4px';
        menu.style.padding = '8px 0';
        menu.style.minWidth = '120px';

        // Add styles
        const style = document.createElement('style');
        style.textContent = `
            .quality-menu__header {
                padding: 8px 16px;
                color: #fff;
                font-size: 12px;
                font-weight: 600;
                text-transform: uppercase;
                border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            }
            .quality-menu__items {
                display: flex;
                flex-direction: column;
            }
            .quality-menu__item {
                display: flex;
                align-items: center;
                justify-content: space-between;
                padding: 8px 16px;
                background: none;
                border: none;
                color: #fff;
                cursor: pointer;
                font-size: 14px;
                width: 100%;
                text-align: left;
            }
            .quality-menu__item:hover {
                background: rgba(255, 255, 255, 0.1);
            }
            .quality-menu__check {
                color: #00d4ff;
                font-weight: bold;
            }
        `;
        document.head.appendChild(style);

        // Add menu to DOM
        this.qualityButton.style.position = 'relative';
        this.qualityButton.appendChild(menu);

        // Bind menu events
        menu.addEventListener('click', (e) => {
            const qualityItem = e.target.closest('.quality-menu__item');
            if (qualityItem) {
                const quality = parseInt(qualityItem.dataset.quality);
                this.changeQuality(quality);
                menu.remove();
            }
        });

        // Close menu when clicking outside
        setTimeout(() => {
            document.addEventListener('click', function closeMenu(e) {
                if (!menu.contains(e.target) && !this.qualityButton.contains(e.target)) {
                    menu.remove();
                    document.removeEventListener('click', closeMenu);
                }
            }.bind(this));
        }, 0);
    }

    isCurrentQuality(quality) {
        return this.videoElement.currentSrc === quality.src;
    }

    async changeQuality(quality) {
        const targetQuality = this.availableQualities.find(q => q.quality === quality);
        if (!targetQuality) return;

        // Store current time and state
        const currentTime = this.videoElement.currentTime;
        const wasPlaying = !this.videoElement.paused;
        const currentVolume = this.videoElement.volume;
        const currentMuted = this.videoElement.muted;

        // Show loading indicator
        this.showLoadingIndicator();

        try {
            // If we have a server-side quality endpoint, use it
            if (this.videoId && targetQuality.id) {
                const response = await fetch(`/api/video/${this.videoId}/stream/${quality}`);
                if (response.ok) {
                    const blob = await response.blob();
                    const newSrc = URL.createObjectURL(blob);
                    
                    // Change source to the new quality
                    this.videoElement.src = newSrc;
                } else {
                    // Fallback to direct source change
                    this.videoElement.src = targetQuality.src;
                }
            } else {
                // Direct source change
                this.videoElement.src = targetQuality.src;
            }

            // Load the new source
            this.videoElement.load();

            // Restore playback state when new source is ready
            this.videoElement.addEventListener('loadeddata', () => {
                this.videoElement.currentTime = currentTime;
                this.videoElement.volume = currentVolume;
                this.videoElement.muted = currentMuted;
                
                if (wasPlaying) {
                    this.videoElement.play().catch(console.error);
                }
                
                this.hideLoadingIndicator();
            }, { once: true });

            // Handle errors
            this.videoElement.addEventListener('error', () => {
                console.error('Error loading video quality:', quality);
                this.hideLoadingIndicator();
            }, { once: true });

            this.currentQuality = quality;
            this.updateQualityLabel();
            
            // Update Plyr player if it exists
            if (this.player && this.player.source) {
                this.player.source = {
                    type: 'video',
                    sources: [{
                        src: this.videoElement.src,
                        type: targetQuality.type
                    }]
                };
            }

        } catch (error) {
            console.error('Error changing video quality:', error);
            this.hideLoadingIndicator();
        }
    }

    showLoadingIndicator() {
        // Create or show loading indicator
        let loader = document.querySelector('.quality-loading');
        if (!loader) {
            loader = document.createElement('div');
            loader.className = 'quality-loading';
            loader.innerHTML = '<div class="spinner"></div><span>Switching quality...</span>';
            loader.style.cssText = `
                position: absolute;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                background: rgba(0, 0, 0, 0.8);
                color: white;
                padding: 20px;
                border-radius: 8px;
                z-index: 1000;
                display: flex;
                flex-direction: column;
                align-items: center;
                gap: 10px;
            `;
            
            const style = document.createElement('style');
            style.textContent = `
                .quality-loading .spinner {
                    width: 20px;
                    height: 20px;
                    border: 2px solid #333;
                    border-top: 2px solid #fff;
                    border-radius: 50%;
                    animation: spin 1s linear infinite;
                }
                @keyframes spin {
                    0% { transform: rotate(0deg); }
                    100% { transform: rotate(360deg); }
                }
            `;
            document.head.appendChild(style);
            
            this.videoElement.parentElement.style.position = 'relative';
            this.videoElement.parentElement.appendChild(loader);
        }
        loader.style.display = 'flex';
    }

    hideLoadingIndicator() {
        const loader = document.querySelector('.quality-loading');
        if (loader) {
            loader.style.display = 'none';
        }
    }

    updateQualityLabel() {
        if (this.qualityButton) {
            const label = this.qualityButton.querySelector('.quality-label');
            if (label) {
                label.textContent = this.getCurrentQualityLabel();
            }
        }
    }
}

// Auto-initialize for all video players
document.addEventListener('DOMContentLoaded', function() {
    // Wait for Plyr to initialize
    setTimeout(() => {
        const videoPlayers = document.querySelectorAll('.video-player');
        videoPlayers.forEach(videoElement => {
            // Check if Plyr is initialized
            if (videoElement.plyr) {
                new VideoQualityManager(videoElement.plyr, videoElement);
            } else {
                // Wait for Plyr to initialize
                const observer = new MutationObserver((mutations) => {
                    if (videoElement.plyr) {
                        new VideoQualityManager(videoElement.plyr, videoElement);
                        observer.disconnect();
                    }
                });
                observer.observe(videoElement, { attributes: true });
            }
        });
    }, 1000);
});

// Export for manual initialization
window.VideoQualityManager = VideoQualityManager;
