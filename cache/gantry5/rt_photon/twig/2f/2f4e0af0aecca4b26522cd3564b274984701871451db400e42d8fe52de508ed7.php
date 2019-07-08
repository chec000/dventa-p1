<?php

/* @particles/block-application.html.twig */
class __TwigTemplate_ee1ac5c53d9961cd72d0aeb5277493fb1907746f17e4fffd7569d2aee864628f extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        $this->parent = $this->loadTemplate("@nucleus/partials/particle.html.twig", "@particles/block-application.html.twig", 1);
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
        echo "    <script>
            \$( document ).ready(function() {
                var trident = !!navigator.userAgent.match(/Trident\\/7.0/);
                var net = !!navigator.userAgent.match(/.NET4.0E/);
                var IE11 = trident && net;

                var IEold = ( navigator.userAgent.match(/MSIE/i) ? true : false );

                if(IE11 || IEold){
                    \$(\"body\").addClass(\"diable-body\");
                    \$(\"body\").append( \"<div id='div_bloqueo'  class='bloqueo'></div>\" );
                    \$(\"#div_bloqueo\").append(\"<div class='centrado'><h4>Favor de utilizar Google Chrome o Mozilla Firefox</h4></div>\");
                }
            });
    </script>

";
    }

    public function getTemplateName()
    {
        return "@particles/block-application.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  31 => 4,  28 => 3,  11 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "@particles/block-application.html.twig", "C:\\xampp\\htdocs\\dventa\\templates\\rt_photon\\custom\\particles\\block-application.html.twig");
    }
}
