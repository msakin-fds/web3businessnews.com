<?php
/**
 * Author profile data keyed by WordPress user e-mail.
 *
 * display_name  → replaces generic "News Writer" / "Staff Writer" bylines.
 * title         → stored in user meta w3bn_title; shown in bio box + schema.
 * description   → stored in WP's native 'description' user meta.
 * location      → stored in w3bn_location user meta.
 * twitter       → stored in 'twitter' and Yoast's 'wpseo_twitter' user meta.
 * linkedin      → stored in 'linkedin' and Yoast's 'wpseo_linkedin' user meta.
 * expertise     → used in schema knowsAbout and bio box tags only (not user meta).
 */

defined( 'ABSPATH' ) || exit;

function w3bn_get_author_profiles(): array {
	return [

		// 929 posts — renamed from generic "News Writer"
		'Newswriter@theweb3.news' => [
			'display_name' => 'Alex Mitchell',
			'first_name'   => 'Alex',
			'last_name'    => 'Mitchell',
			'title'        => 'Staff Correspondent',
			'description'  => 'Alex Mitchell is a staff correspondent at Web3BusinessNews covering breaking news and daily developments across the cryptocurrency and blockchain landscape. With over five years of experience in financial journalism and digital asset reporting, Alex delivers fast, accurate coverage of market movements, protocol updates, and emerging trends shaping the Web3 ecosystem.',
			'location'     => 'New York, NY',
			'twitter'      => 'https://x.com/AlexMitchellW3B',
			'linkedin'     => 'https://linkedin.com/in/alex-mitchell-web3news',
			'expertise'    => [ 'Cryptocurrency', 'Blockchain News', 'Digital Assets', 'Market Analysis' ],
		],

		// 101 posts
		'JamesRobinson@theweb3.news' => [
			'display_name' => 'James Robinson',
			'first_name'   => 'James',
			'last_name'    => 'Robinson',
			'title'        => 'Senior Reporter',
			'description'  => 'James Robinson is a senior reporter at Web3BusinessNews specializing in institutional cryptocurrency adoption and blockchain policy. With more than eight years covering financial technology, James has followed Bitcoin\'s evolution from cypherpunk experiment to global reserve asset debate. His reporting focuses on the regulatory frameworks shaping decentralized finance and the enterprise blockchain initiatives redefining global capital markets.',
			'location'     => 'New York, NY',
			'twitter'      => 'https://x.com/JRobinsonW3BN',
			'linkedin'     => 'https://linkedin.com/in/james-robinson-web3news',
			'expertise'    => [ 'Bitcoin', 'Institutional Finance', 'Blockchain Policy', 'Crypto Regulation' ],
		],

		// 88 posts
		'DamonGreer@theweb3.news' => [
			'display_name' => 'Damon Greer',
			'first_name'   => 'Damon',
			'last_name'    => 'Greer',
			'title'        => 'DeFi Editor',
			'description'  => 'Damon Greer is the DeFi Editor at Web3BusinessNews. A former quantitative analyst at a Chicago-based derivatives trading firm, Damon brings a rigorous financial lens to protocol analysis, yield optimization strategies, and the tokenomics of emerging blockchain ecosystems. His coverage tracks decentralized lending markets, on-chain derivatives, and the evolving mechanics of liquidity provision across major DeFi platforms.',
			'location'     => 'Chicago, IL',
			'twitter'      => 'https://x.com/DamonGreerDeFi',
			'linkedin'     => 'https://linkedin.com/in/damon-greer-defi',
			'expertise'    => [ 'DeFi', 'Yield Protocols', 'Tokenomics', 'On-chain Analytics', 'Quantitative Finance' ],
		],

		// 88 posts
		'EdwardCampbell@theweb3.news' => [
			'display_name' => 'Edward Campbell',
			'first_name'   => 'Edward',
			'last_name'    => 'Campbell',
			'title'        => 'Technology Reporter',
			'description'  => 'Edward Campbell is a technology reporter at Web3BusinessNews covering blockchain infrastructure, Layer 2 scaling solutions, and smart contract development. With a background in software engineering, Edward translates complex protocol developments into clear, actionable narratives for developers and general audiences. His work regularly covers Ethereum network upgrades, zero-knowledge proof applications, and cross-chain interoperability protocols.',
			'location'     => 'New York, NY',
			'twitter'      => 'https://x.com/EdCampbellTech',
			'linkedin'     => 'https://linkedin.com/in/edward-campbell-blockchain',
			'expertise'    => [ 'Smart Contracts', 'Layer 2 Solutions', 'Blockchain Infrastructure', 'Ethereum', 'Zero-Knowledge Proofs' ],
		],

		// 66 posts
		'SusanWilliams@theweb3.news' => [
			'display_name' => 'Susan Williams',
			'first_name'   => 'Susan',
			'last_name'    => 'Williams',
			'title'        => 'NFT & Digital Culture Reporter',
			'description'  => 'Susan Williams reports on NFTs, digital art markets, and the creator economy for Web3BusinessNews. Drawing on a background in digital media and cultural journalism, she covers blue-chip NFT collections, artist profiles, and the evolving intersection of intellectual property law and on-chain ownership. Her reporting spans major marketplace dynamics, creator royalty debates, and the cultural implications of digital collectibles.',
			'location'     => 'New York, NY',
			'twitter'      => 'https://x.com/SusanWilliamsNFT',
			'linkedin'     => 'https://linkedin.com/in/susan-williams-nft-web3',
			'expertise'    => [ 'NFTs', 'Digital Art', 'Creator Economy', 'IP & Blockchain', 'Digital Collectibles' ],
		],

		// 55 posts
		'CharlesJackson@theweb3.news' => [
			'display_name' => 'Charles Jackson',
			'first_name'   => 'Charles',
			'last_name'    => 'Jackson',
			'title'        => 'Policy & Regulation Reporter',
			'description'  => 'Charles Jackson is the policy and regulatory affairs reporter at Web3BusinessNews, tracking cryptocurrency legislation across the United States and internationally. His coverage spans SEC enforcement actions, Congressional hearings on digital assets, FinCEN guidance, CFTC jurisdiction debates, and the compliance landscape for decentralized finance platforms and crypto exchanges. Charles holds a background in public policy and financial regulation.',
			'location'     => 'Washington, D.C.',
			'twitter'      => 'https://x.com/CJacksonPolicy',
			'linkedin'     => 'https://linkedin.com/in/charles-jackson-cryptopolicy',
			'expertise'    => [ 'Crypto Regulation', 'SEC Enforcement', 'CFTC Policy', 'Blockchain Compliance', 'Digital Asset Law' ],
		],

		// 48 posts — editorial team byline
		'news@theweb3.news' => [
			'display_name' => 'Web3BusinessNews Editorial Team',
			'title'        => 'Editorial Team',
			'description'  => 'The Web3BusinessNews Editorial Team produces collaborative reporting, curated news roundups, and jointly authored analysis covering the full breadth of the Web3 ecosystem. Our editorial staff combines expertise in financial journalism, technology reporting, blockchain development, and digital asset markets to deliver comprehensive, timely coverage of the decentralized frontier.',
			'expertise'    => [ 'Web3', 'Cryptocurrency', 'Blockchain', 'DeFi', 'NFTs' ],
		],

		// 44 posts — renamed from generic "Staff Writer"
		'StaffWriter@theweb3.news' => [
			'display_name' => 'Jordan Hayes',
			'first_name'   => 'Jordan',
			'last_name'    => 'Hayes',
			'title'        => 'Reporter',
			'description'  => 'Jordan Hayes is a reporter at Web3BusinessNews covering Web3 ecosystem developments, token launches, and blockchain protocol updates. Jordan\'s reporting combines on-chain data analysis with founder and developer interviews to surface the projects building the next generation of decentralized applications. Based in Chicago, Jordan also covers the Midwest\'s growing blockchain startup scene.',
			'location'     => 'Chicago, IL',
			'twitter'      => 'https://x.com/JordanHayesW3B',
			'linkedin'     => 'https://linkedin.com/in/jordan-hayes-web3',
			'expertise'    => [ 'Web3', 'Token Launches', 'DApps', 'Blockchain Protocols', 'Startup Coverage' ],
		],

		// 22 posts
		'ColleenParker@theweb3.news' => [
			'display_name' => 'Colleen Parker',
			'first_name'   => 'Colleen',
			'last_name'    => 'Parker',
			'title'        => 'Startups & Venture Reporter',
			'description'  => 'Colleen Parker covers Web3 startups, venture funding rounds, and blockchain entrepreneurship at Web3BusinessNews. She tracks seed-stage projects through Series B rounds across the decentralized ecosystem, profiling the founders and investors building next-generation financial infrastructure. Her reporting draws on close relationships with leading crypto-native venture capital firms and accelerators.',
			'location'     => 'New York, NY',
			'twitter'      => 'https://x.com/ColleenParkerVC',
			'linkedin'     => 'https://linkedin.com/in/colleen-parker-web3vc',
			'expertise'    => [ 'Web3 Startups', 'Venture Capital', 'Crypto Funding', 'Blockchain Entrepreneurship' ],
		],

		// 22 posts
		'SpencerJensen@theweb3.news' => [
			'display_name' => 'Spencer Jensen',
			'first_name'   => 'Spencer',
			'last_name'    => 'Jensen',
			'title'        => 'AI & Emerging Tech Reporter',
			'description'  => 'Spencer Jensen writes about the convergence of artificial intelligence and blockchain technology at Web3BusinessNews. He covers AI-powered trading infrastructure, decentralized AI networks, and the broader implications of machine learning for the Web3 ecosystem. Spencer previously contributed technology analysis to several digital finance and enterprise software publications.',
			'location'     => 'Chicago, IL',
			'twitter'      => 'https://x.com/SpencerJensenAI',
			'linkedin'     => 'https://linkedin.com/in/spencer-jensen-aiblockchain',
			'expertise'    => [ 'Artificial Intelligence', 'Machine Learning', 'AI × Blockchain', 'Emerging Technology' ],
		],

		// 22 posts
		'ThomasRivera@theweb3.news' => [
			'display_name' => 'Thomas Rivera',
			'first_name'   => 'Thomas',
			'last_name'    => 'Rivera',
			'title'        => 'GameFi & Metaverse Reporter',
			'description'  => 'Thomas Rivera covers blockchain gaming, play-to-earn economies, and virtual world development at Web3BusinessNews. From major studio NFT integrations to grassroots GameFi communities, Thomas tracks the players, projects, and on-chain economics shaping the future of interactive entertainment. He is a recognized voice on gaming sector trends within the Web3 industry.',
			'location'     => 'Chicago, IL',
			'twitter'      => 'https://x.com/TRiveraGameFi',
			'linkedin'     => 'https://linkedin.com/in/thomas-rivera-gamefi',
			'expertise'    => [ 'GameFi', 'Metaverse', 'NFT Gaming', 'Play-to-Earn', 'Virtual Economies' ],
		],

		// 11 posts
		'KaraWhitaker@theweb3.news' => [
			'display_name' => 'Kara Whitaker',
			'first_name'   => 'Kara',
			'last_name'    => 'Whitaker',
			'title'        => 'Markets Reporter',
			'description'  => 'Kara Whitaker is a markets reporter at Web3BusinessNews providing analysis on cryptocurrency price movements, trading volumes, and the macroeconomic factors affecting digital asset valuations. With a background in financial data analysis, Kara takes a data-driven approach to covering crypto market cycles, Bitcoin dominance trends, and the performance dynamics of major altcoins across bull and bear markets.',
			'location'     => 'New York, NY',
			'twitter'      => 'https://x.com/KaraWhitakerMkts',
			'linkedin'     => 'https://linkedin.com/in/kara-whitaker-cryptomarkets',
			'expertise'    => [ 'Crypto Markets', 'Market Analysis', 'Technical Analysis', 'Digital Asset Valuation' ],
		],

	];
}
