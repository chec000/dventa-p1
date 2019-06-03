<?php

/* @particles/atomo-Ir-arriba.html.twig */
class __TwigTemplate_3bb4d641c7463cb60bb31af37683ef93da0a46d86644df66733fd9de86218f78 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        $this->parent = $this->loadTemplate("@nucleus/partials/particle.html.twig", "@particles/atomo-Ir-arriba.html.twig", 1);
        $this->blocks = array(
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
    public function block_javascript_footer($context, array $blocks = array())
    {
        // line 4
        echo "    ";
        if ($this->getAttribute(($context["particle"] ?? null), "enabled", array())) {
            // line 5
            echo "        ";
            $this->getAttribute(($context["gantry"] ?? null), "load", array(0 => "jquery"), "method");
            // line 6
            echo "        ";
            $this->displayParentBlock("javascript_footer", $context, $blocks);
            echo "        
            <script>
                (function(\$) {
                    \$(window).load(function() {

             \$('body').append('<a class=\"ir-arriba ir-arriba-";
            // line 11
            echo twig_escape_filter($this->env, $this->getAttribute(($context["particle"] ?? null), "efecto", array()));
            echo "-defecto ";
            if ($this->getAttribute(($context["particle"] ?? null), "colorfondo", array())) {
                echo "g-ir-arriba-confondo";
            }
            echo "\" href=\"#\" style=\"";
            if ($this->getAttribute(($context["particle"] ?? null), "colorfondo", array())) {
                echo "background:";
                echo twig_escape_filter($this->env, $this->getAttribute(($context["particle"] ?? null), "colorfondo", array()));
                echo ";";
            }
            if ($this->getAttribute(($context["particle"] ?? null), "coloricono", array())) {
                echo "color:";
                echo twig_escape_filter($this->env, $this->getAttribute(($context["particle"] ?? null), "coloricono", array()));
                echo ";";
            }
            if ($this->getAttribute(($context["particle"] ?? null), "borderradius", array())) {
                echo "border-radius:";
                echo twig_escape_filter($this->env, $this->getAttribute(($context["particle"] ?? null), "borderradius", array()));
                echo ";";
            }
            if ($this->getAttribute(($context["particle"] ?? null), "espaciado", array())) {
                echo "padding:";
                echo twig_escape_filter($this->env, $this->getAttribute(($context["particle"] ?? null), "espaciado", array()));
                echo ";";
            }
            if ($this->getAttribute(($context["particle"] ?? null), "grosorborde", array())) {
                echo "border:";
                echo twig_escape_filter($this->env, $this->getAttribute(($context["particle"] ?? null), "grosorborde", array()));
                echo " solid";
            }
            if ($this->getAttribute(($context["particle"] ?? null), "colorborde", array())) {
                echo " ";
                echo twig_escape_filter($this->env, $this->getAttribute(($context["particle"] ?? null), "colorborde", array()));
            }
            echo ";\"><i class=\"";
            echo twig_escape_filter($this->env, $this->getAttribute(($context["particle"] ?? null), "buttonicon", array()));
            echo "\" aria-hidden=\"true\"> </i> </a>'); 

                     \$(window).scroll(function () {
                    if (\$(this).scrollTop() > ";
            // line 14
            echo twig_escape_filter($this->env, $this->getAttribute(($context["particle"] ?? null), "offset", array()));
            echo ") {
                        \$('.ir-arriba').addClass('ir-arriba-";
            // line 15
            echo twig_escape_filter($this->env, $this->getAttribute(($context["particle"] ?? null), "efecto", array()));
            echo "');
                    } else {
                        \$('.ir-arriba').removeClass('ir-arriba-";
            // line 17
            echo twig_escape_filter($this->env, $this->getAttribute(($context["particle"] ?? null), "efecto", array()));
            echo "');
                    }
                    });

                     \$('.ir-arriba').click(function () {
                     \$('body,html').animate({
                        scrollTop: 0,
                        }, ";
            // line 24
            echo twig_escape_filter($this->env, $this->getAttribute(($context["particle"] ?? null), "velocidadscroll", array()));
            echo ");
                        return false;
                    });

                    });
                })(jQuery);
            </script>
        ";
        }
    }

    public function getTemplateName()
    {
        return "@particles/atomo-Ir-arriba.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  107 => 24,  97 => 17,  92 => 15,  88 => 14,  46 => 11,  37 => 6,  34 => 5,  31 => 4,  28 => 3,  11 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "@particles/atomo-Ir-arriba.html.twig", "/var/www/html/templates/rt_photon/custom/particles/atomo-Ir-arriba.html.twig");
    }
}
