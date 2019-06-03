<?php

/* @particles/owlcarousel.html.twig */
class __TwigTemplate_98e2b30a79e43531342ee33dfe8fa3c8bc1914d1e81d51736bf154505d8dc022 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        $this->parent = $this->loadTemplate("@nucleus/partials/particle.html.twig", "@particles/owlcarousel.html.twig", 1);
        $this->blocks = array(
            'particle' => array($this, 'block_particle'),
            'javascript_footer' => array($this, 'block_javascript_footer'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "@nucleus/partials/particle.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    public function block_particle($context, array $blocks = array())
    {
        // line 4
        echo "
";
        // line 5
        if ($this->getAttribute(($context["particle"] ?? null), "footerShadow", array())) {
            // line 6
            $assetFunction = $this->env->getFunction('parse_assets')->getCallable();
            $assetVariables = array("priority" =>  -10);
            if ($assetVariables && !is_array($assetVariables)) {
                throw new UnexpectedValueException('{% scripts with x %}: x is not an array');
            }
            $location = "head";
            if ($location && !is_string($location)) {
                throw new UnexpectedValueException('{% scripts in x %}: x is not a string');
            }
            $priority = isset($assetVariables['priority']) ? $assetVariables['priority'] : 0;
            ob_start();
            // line 7
            echo "<style>
";
            // line 8
            if (($this->getAttribute(($context["particle"] ?? null), "layout", array()) == "standard")) {
                // line 9
                echo "#g-owlcarousel-";
                echo twig_escape_filter($this->env, ($context["id"] ?? null), "html", null, true);
                echo " .g-owlcarousel-item-img:after {
  background: rgba(0, 0, 0, 0);
  background: -webkit-linear-gradient(rgba(0, 0, 0, 0), ";
                // line 11
                echo twig_escape_filter($this->env, (($this->getAttribute(($context["particle"] ?? null), "footerShadowColor", array(), "any", true, true)) ? (_twig_default_filter($this->getAttribute(($context["particle"] ?? null), "footerShadowColor", array()), "#ffffff")) : ("#ffffff")), "html", null, true);
                echo ");
  background: -o-linear-gradient(rgba(0, 0, 0, 0), ";
                // line 12
                echo twig_escape_filter($this->env, (($this->getAttribute(($context["particle"] ?? null), "footerShadowColor", array(), "any", true, true)) ? (_twig_default_filter($this->getAttribute(($context["particle"] ?? null), "footerShadowColor", array()), "#ffffff")) : ("#ffffff")), "html", null, true);
                echo ");
  background: -moz-linear-gradient(rgba(0, 0, 0, 0), ";
                // line 13
                echo twig_escape_filter($this->env, (($this->getAttribute(($context["particle"] ?? null), "footerShadowColor", array(), "any", true, true)) ? (_twig_default_filter($this->getAttribute(($context["particle"] ?? null), "footerShadowColor", array()), "#ffffff")) : ("#ffffff")), "html", null, true);
                echo ");
  background: linear-gradient(rgba(0, 0, 0, 0), ";
                // line 14
                echo twig_escape_filter($this->env, (($this->getAttribute(($context["particle"] ?? null), "footerShadowColor", array(), "any", true, true)) ? (_twig_default_filter($this->getAttribute(($context["particle"] ?? null), "footerShadowColor", array()), "#ffffff")) : ("#ffffff")), "html", null, true);
                echo ");
}
";
            }
            // line 17
            echo "
";
            // line 18
            if (($this->getAttribute(($context["particle"] ?? null), "layout", array()) == "testimonial")) {
                // line 19
                $context['_parent'] = $context;
                $context['_seq'] = twig_ensure_traversable($this->getAttribute(($context["particle"] ?? null), "items", array()));
                $context['loop'] = array(
                  'parent' => $context['_parent'],
                  'index0' => 0,
                  'index'  => 1,
                  'first'  => true,
                );
                if (is_array($context['_seq']) || (is_object($context['_seq']) && $context['_seq'] instanceof Countable)) {
                    $length = count($context['_seq']);
                    $context['loop']['revindex0'] = $length - 1;
                    $context['loop']['revindex'] = $length;
                    $context['loop']['length'] = $length;
                    $context['loop']['last'] = 1 === $length;
                }
                foreach ($context['_seq'] as $context["_key"] => $context["item"]) {
                    // line 20
                    echo "#g-owlcarousel-";
                    echo twig_escape_filter($this->env, ($context["id"] ?? null), "html", null, true);
                    echo " .owl-dots .owl-dot:nth-child(";
                    echo twig_escape_filter($this->env, $this->getAttribute($context["loop"], "index", array()), "html", null, true);
                    echo ") {
  background: url('";
                    // line 21
                    echo twig_escape_filter($this->env, $this->env->getExtension('Gantry\Component\Twig\TwigExtension')->urlFunc($this->getAttribute($context["item"], "image", array())));
                    echo "');
  background-size: cover;
}
";
                    ++$context['loop']['index0'];
                    ++$context['loop']['index'];
                    $context['loop']['first'] = false;
                    if (isset($context['loop']['length'])) {
                        --$context['loop']['revindex0'];
                        --$context['loop']['revindex'];
                        $context['loop']['last'] = 0 === $context['loop']['revindex0'];
                    }
                }
                $_parent = $context['_parent'];
                unset($context['_seq'], $context['_iterated'], $context['_key'], $context['item'], $context['_parent'], $context['loop']);
                $context = array_intersect_key($context, $_parent) + $_parent;
            }
            // line 26
            echo "
</style>
";
            $content = ob_get_clean();
            $assetFunction($content, $location, $priority);
        }
        // line 30
        echo "
";
        // line 31
        if (($this->getAttribute(($context["particle"] ?? null), "layout", array()) == "standard")) {
            // line 32
            echo "<div class=\"";
            echo twig_escape_filter($this->env, $this->getAttribute(($context["particle"] ?? null), "class", array()));
            echo "\">
  ";
            // line 33
            if ($this->getAttribute(($context["particle"] ?? null), "title", array())) {
                echo "<h2 class=\"g-title\">";
                echo $this->getAttribute(($context["particle"] ?? null), "title", array());
                echo "</h2>";
            }
            // line 34
            echo "  <div id=\"g-owlcarousel-";
            echo twig_escape_filter($this->env, ($context["id"] ?? null), "html", null, true);
            echo "\" class=\"g-owlcarousel owl-carousel ";
            echo twig_escape_filter($this->env, $this->getAttribute(($context["particle"] ?? null), "width", array()));
            echo "\">
    ";
            // line 35
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable($this->getAttribute(($context["particle"] ?? null), "items", array()));
            foreach ($context['_seq'] as $context["_key"] => $context["item"]) {
                // line 36
                echo "    <div>
      <img src=\"";
                // line 37
                echo twig_escape_filter($this->env, $this->env->getExtension('Gantry\Component\Twig\TwigExtension')->urlFunc($this->getAttribute($context["item"], "image", array())));
                echo "\" alt=\"";
                echo twig_escape_filter($this->env, $this->getAttribute($context["item"], "title", array()));
                echo "\">
      ";
                // line 38
                if ($this->getAttribute($context["item"], "title", array())) {
                    echo "<div class=\"g-owlcarousel-item-title\">";
                    echo $this->getAttribute($context["item"], "title", array());
                    echo "</div>";
                }
                // line 39
                echo "      ";
                if ($this->getAttribute($context["item"], "desc", array())) {
                    echo "<div class=\"g-owlcarousel-item-desc\">";
                    echo $this->getAttribute($context["item"], "desc", array());
                    echo "</div>";
                }
                // line 40
                echo "      ";
                if ($this->getAttribute($context["item"], "link", array())) {
                    echo "<div class=\"g-owlcarousel-item-link\"><a target=\"";
                    echo twig_escape_filter($this->env, (($this->getAttribute($context["item"], "buttontarget", array(), "any", true, true)) ? (_twig_default_filter($this->getAttribute($context["item"], "buttontarget", array()), "_self")) : ("_self")));
                    echo "\" class=\"g-owlcarousel-item-button button ";
                    echo twig_escape_filter($this->env, $this->getAttribute($context["item"], "buttonclass", array()));
                    echo "\" href=\"";
                    echo twig_escape_filter($this->env, $this->getAttribute($context["item"], "link", array()));
                    echo "\">";
                    echo $this->getAttribute($context["item"], "linktext", array());
                    echo "</a></div>";
                }
                // line 41
                echo "    </div>
    ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['item'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 43
            echo "  </div>
</div>
";
        } elseif (($this->getAttribute(        // line 45
($context["particle"] ?? null), "layout", array()) == "testimonial")) {
            // line 46
            echo "<div class=\"";
            echo twig_escape_filter($this->env, $this->getAttribute(($context["particle"] ?? null), "class", array()));
            echo " g-owlcarousel-layout-";
            echo twig_escape_filter($this->env, $this->getAttribute(($context["particle"] ?? null), "layout", array()));
            echo "\">
  ";
            // line 47
            if ($this->getAttribute(($context["particle"] ?? null), "title", array())) {
                echo "<h2 class=\"g-title\">";
                echo $this->getAttribute(($context["particle"] ?? null), "title", array());
                echo "</h2>";
            }
            // line 48
            echo "  <div id=\"g-owlcarousel-";
            echo twig_escape_filter($this->env, ($context["id"] ?? null), "html", null, true);
            echo "\" class=\"g-owlcarousel owl-carousel ";
            echo twig_escape_filter($this->env, $this->getAttribute(($context["particle"] ?? null), "width", array()));
            echo "\">
    ";
            // line 49
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable($this->getAttribute(($context["particle"] ?? null), "items", array()));
            foreach ($context['_seq'] as $context["_key"] => $context["item"]) {
                // line 50
                echo "
    ";
                // line 51
                if ($this->getAttribute($context["item"], "desc", array())) {
                    echo "<div class=\"g-owlcarousel-item-desc\">
      ";
                    // line 52
                    if ($this->getAttribute($context["item"], "icon", array())) {
                        echo "<i class=\"";
                        echo twig_escape_filter($this->env, $this->getAttribute($context["item"], "icon", array()), "html", null, true);
                        echo "\"></i>";
                    }
                    // line 53
                    echo "      ";
                    echo $this->getAttribute($context["item"], "desc", array());
                    echo "
    </div>
    ";
                }
                // line 56
                echo "    ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['item'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 57
            echo "  </div>
</div>
";
        }
    }

    // line 62
    public function block_javascript_footer($context, array $blocks = array())
    {
        // line 63
        echo "<script src=\"";
        echo twig_escape_filter($this->env, $this->env->getExtension('Gantry\Component\Twig\TwigExtension')->urlFunc("gantry-theme://js/owlcarousel.js"), "html", null, true);
        echo "\"></script>
<script type=\"text/javascript\">
jQuery(window).load(function(){
  jQuery('#g-owlcarousel-";
        // line 66
        echo twig_escape_filter($this->env, ($context["id"] ?? null), "html", null, true);
        echo "').owlCarousel({
    items: 1,
    rtl: ";
        // line 68
        if (($this->getAttribute($this->getAttribute(($context["gantry"] ?? null), "page", array()), "direction", array()) == "rtl")) {
            echo "true";
        } else {
            echo "false";
        }
        echo ",
    ";
        // line 69
        if ($this->getAttribute(($context["particle"] ?? null), "animateOut", array())) {
            // line 70
            echo "    animateOut: '";
            echo twig_escape_filter($this->env, (($this->getAttribute(($context["particle"] ?? null), "animateOut", array(), "any", true, true)) ? (_twig_default_filter($this->getAttribute(($context["particle"] ?? null), "animateOut", array()), "fadeOut")) : ("fadeOut")));
            echo "',
    ";
        }
        // line 72
        echo "    ";
        if ($this->getAttribute(($context["particle"] ?? null), "animateIn", array())) {
            // line 73
            echo "      animateIn: '";
            echo twig_escape_filter($this->env, (($this->getAttribute(($context["particle"] ?? null), "animateIn", array(), "any", true, true)) ? (_twig_default_filter($this->getAttribute(($context["particle"] ?? null), "animateIn", array()), "fadeIn")) : ("fadeIn")));
            echo "',
    ";
        }
        // line 75
        echo "    ";
        if ($this->getAttribute(($context["particle"] ?? null), "nav", array())) {
            // line 76
            echo "    nav: true,
    navText: ['";
            // line 77
            echo twig_escape_filter($this->env, twig_escape_filter($this->env, (($this->getAttribute(($context["particle"] ?? null), "prevText", array(), "any", true, true)) ? (_twig_default_filter($this->getAttribute(($context["particle"] ?? null), "prevText", array()), "<i class=\"fa fa-chevron-left\"></i>")) : ("<i class=\"fa fa-chevron-left\"></i>")), "js"), "html", null, true);
            echo "', '";
            echo twig_escape_filter($this->env, twig_escape_filter($this->env, (($this->getAttribute(($context["particle"] ?? null), "nextText", array(), "any", true, true)) ? (_twig_default_filter($this->getAttribute(($context["particle"] ?? null), "nextText", array()), "<i class=\"fa fa-chevron-right\"></i>")) : ("<i class=\"fa fa-chevron-right\"></i>")), "js"), "html", null, true);
            echo "'],
    ";
        } else {
            // line 79
            echo "    nav: false,
    ";
        }
        // line 81
        echo "    ";
        if ($this->getAttribute(($context["particle"] ?? null), "dots", array())) {
            // line 82
            echo "    dots: true,
    ";
        } else {
            // line 84
            echo "    dots: false,
    ";
        }
        // line 86
        echo "    ";
        if ($this->getAttribute(($context["particle"] ?? null), "loop", array())) {
            // line 87
            echo "    loop: true,
    ";
        } else {
            // line 89
            echo "    loop: false,
    ";
        }
        // line 91
        echo "    ";
        if ($this->getAttribute(($context["particle"] ?? null), "autoplay", array())) {
            // line 92
            echo "    autoplay: true,
    autoplayTimeout: ";
            // line 93
            echo twig_escape_filter($this->env, (($this->getAttribute(($context["particle"] ?? null), "autoplaySpeed", array(), "any", true, true)) ? (_twig_default_filter($this->getAttribute(($context["particle"] ?? null), "autoplaySpeed", array()), "5000")) : ("5000")), "html", null, true);
            echo ",
    autoplayHoverPause: ";
            // line 94
            echo twig_escape_filter($this->env, $this->getAttribute(($context["particle"] ?? null), "pauseOnHover", array()));
            echo ",
    ";
        } else {
            // line 96
            echo "    autoplay: false,
    ";
        }
        // line 98
        echo "  })
});
</script>
";
    }

    public function getTemplateName()
    {
        return "@particles/owlcarousel.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  363 => 98,  359 => 96,  354 => 94,  350 => 93,  347 => 92,  344 => 91,  340 => 89,  336 => 87,  333 => 86,  329 => 84,  325 => 82,  322 => 81,  318 => 79,  311 => 77,  308 => 76,  305 => 75,  299 => 73,  296 => 72,  290 => 70,  288 => 69,  280 => 68,  275 => 66,  268 => 63,  265 => 62,  258 => 57,  252 => 56,  245 => 53,  239 => 52,  235 => 51,  232 => 50,  228 => 49,  221 => 48,  215 => 47,  208 => 46,  206 => 45,  202 => 43,  195 => 41,  182 => 40,  175 => 39,  169 => 38,  163 => 37,  160 => 36,  156 => 35,  149 => 34,  143 => 33,  138 => 32,  136 => 31,  133 => 30,  126 => 26,  107 => 21,  100 => 20,  83 => 19,  81 => 18,  78 => 17,  72 => 14,  68 => 13,  64 => 12,  60 => 11,  54 => 9,  52 => 8,  49 => 7,  37 => 6,  35 => 5,  32 => 4,  29 => 3,  11 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "@particles/owlcarousel.html.twig", "C:\\xampp\\htdocs\\dventa\\templates\\rt_photon\\particles\\owlcarousel.html.twig");
    }
}
